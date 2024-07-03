<?php

namespace App\Services;

use Exception;
use App\Models\Generate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use App\Services\Interfaces\GenerateServiceInterface;
use App\Repositories\Interfaces\GenerateRepositoryInterface as GenerateRepository;

/**
 * Class UserService
 * @package App\Services
 */
class GenerateService implements GenerateServiceInterface
{
     protected $GenerateRepository;
     public function __construct(GenerateRepository $GenerateRepository)
     {
          $this->GenerateRepository = $GenerateRepository;
     }

     public function paginate($request)
     {
          $condition['keyword'] = addslashes($request->input('keyword'));
          $perPage = $request->integer('perpage');
          $Generate =
               $this->GenerateRepository->pagination(['id', 'schema', 'name'], $condition, [], $perPage, []);
          return $Generate;
     }

     public function create($request)
     {
          DB::beginTransaction();
          try {

               $this->makeDatabase($request);
               $this->makeController($request);
               $this->makeModel($request);
               $this->makeRepository($request);
               $this->makeService($request);
               $this->makeProvider($request);
                $this->makeView($request);
                $this->makeRoute($request);
                die();
               $payload = $request->except(['_token', 'send']);
               $Generate = $this->GenerateRepository->create($payload);
               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }

     private function makeRoute($request){
          $name = $request->input('name');
          $routePath = base_path('routes/web.php');
          $module = $this->convertModuleNameToTableName($name);
          $moduleExtract = explode('_',$module);
          $content = file_get_contents($routePath);
          $routeUrl = (count($moduleExtract)==2) ? "{$moduleExtract[0]}/{$moduleExtract[1]}" : $moduleExtract[0];
          $routeName = (count($moduleExtract)==2) ? "{$moduleExtract[0]}.{$moduleExtract[1]}" : $moduleExtract[0];
          $routeGroup = <<<ROUTE
     Route::group(['prefix' => '$routeUrl'], function () {
      Route::get('index', [{$name}Controller::class, "index"])->name('$routeName.index')->middleware('admin');
    Route::get('create', [{$name}Controller::class, "create"])->name('$routeName.create')->middleware('admin');
    Route::post('store', [{$name}Controller::class, "store"])->name('$routeName.store')->middleware('admin');
    Route::get('{id}/edit', [{$name}Controller::class, "edit"])->name('$routeName.edit')->middleware('admin');
    Route::get('{id}/delete', [{$name}Controller::class, "delete"])->name('$routeName.delete')->middleware('admin');
    Route::post('{id}/update', [{$name}Controller::class, "update"])->name('$routeName.update')->middleware('admin');
    Route::post('{id}/destroy', [{$name}Controller::class, "destroy"])->name('$routeName.destroy')->middleware('admin');
});
//@@new-route@@
ROUTE;
          $controller = <<<ROUTE
          use App\\Http\\Controllers\\Backend\\{$name}Controller;
          //@@new-use@@
     ROUTE;
          $content = str_replace('//@@new-route@@',$routeGroup,$content);
          $content = str_replace('//@@new-use@@', $controller,$content);
          FILE::put($routePath,$content);
     }
     private function makeView($request){
          $name = $request->input('name');
          $module = $this->convertModuleNameToTableName($name);
          $extractModule = explode('_', $module);
          $basePath = resource_path("views\\backend\\{$extractModule[0]}");

          $folderPath = (count($extractModule) == 2) ? "$basePath\\{$extractModule[1]}": "$basePath\\{$extractModule[0]}";

          $componentPath = "{$folderPath}\\component";
          if (!FILe::exists($folderPath)) {
               FILE::makeDirectory($folderPath,0755,true);
          }
          if(!FILe::exists($componentPath)){
               FILE::makeDirectory($componentPath,0755,true);
          }

          $sourcePath  = base_path('app/Template/views\\'.((count($extractModule)==2)?'catalogue':'post').'\\');
          $fileArray = [
               'create.blade.php',
               'index.blade.php',
               'delete.blade.php',
          ];

          foreach($fileArray as $key => $val){
               $sourceFile = $sourcePath.$val;

               $destination = "{$folderPath}\\{$val}";
               $content = file_get_contents($sourceFile);
               $viewPath = (count($extractModule)==2) ? "{$extractModule[0]}.{$extractModule[1]}": $extractModule[0];
               $replace = [
                    'view' =>  $viewPath,
                    'module' => lcfirst($name),
                    'Module' =>$name
               ];
               foreach($replace as $key => $val){
                    $content = str_replace('{'.$key.'}', $replace[$key], $content);
               }
               if(!FILE::exists($destination)){
                    FILE::put($destination, $content);
               }
          }


          $fileComponentArray = [
               'filter.blade.php',
               'table.blade.php',
               'tool.blade.php',
          ];

          foreach ($fileComponentArray as $key => $val) {
               $source= "{$sourcePath}component/{$val}";

               $destination = "{$componentPath}\\{$val}";
               $contentComponent = file_get_contents($source);
               $viewPath = (count($extractModule) == 2) ? "{$extractModule[0]}.{$extractModule[1]}" : $extractModule[0];
               $replace = [
                    'view' =>  $viewPath,
                    'module' => lcfirst($name),
                    'Module' => $name
               ];
               foreach ($replace as $key => $val) {
                    $contentComponent = str_replace('{' . $key . '}', $replace[$key], $contentComponent);
               }
               if (!FILE::exists($destination)) {
                    FILE::put($destination, $contentComponent);
               }
          }

     }

     private function makeProvider($request){
          try {
              $name =  $request->input('name');
              $provider = [
               'providerPath' => base_path('app/Providers/AppServiceProvider.php'),
               'repositoryProviderPath' => base_path('app/Providers/RepositoryServiceProvider.php'),
              ];

              foreach($provider as $key => $val){
               $content = file_get_contents($val);
               $insertLine = ($key == 'providerPath') ? "'App\\Services\\Interfaces\\{$name}ServiceInterface' => 'App\\Services\\{$name}Service',": "'App\\Repositories\\Interfaces\\{$name}RepositoryInterface' => 'App\\Repositories\\{$name}Repository',";
               $position = strpos($content,"];");
               if($position !== false){
                    $newContent = substr_replace($content,"    ".$insertLine."\n"."    ",$position,0);
               }
               FILE::put($val,$newContent);
              }

               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               return false;
          }
     }

     private function makeDatabase($request)
     {
          try {
               $payload = $request->only('schema', 'name', 'module_type');
               $module = $this->convertModuleNameToTableName($payload['name']) ;
               $moduleExtract = explode('_', $module);
               $this->makeMainTable($request, $module);

               if ($payload['module_type'] !== 3) {
                    $this->makePivotTable($request, $module);
                    if(count($moduleExtract)== 1){
                         $this->makeRelationTable($request, $module);
                    }
               }
               ARTISAN::call('migrate');
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();

               return false;
          }
     }

     private function makeRelationTable($request, $module){
          $tableName = $module.'_catalogue_'.$module;
          $relationSchema = $this->relationSchema($module);
          $migrationRelationFileName = date('Y_m_d_His', time() + 11) . '_' . 'create_' . $tableName . '_table.php';
          $migrationRelationPath = database_path('migrations/' . $migrationRelationFileName);

          $migrationRelationTemplate = $this->createMainTable([
               'schema' => $relationSchema,
               'name' =>   $tableName,
          ], $tableName);
          FILE::put($migrationRelationPath, $migrationRelationTemplate);
     }
private function makePivotTable($request, $module){
          $payload = $request->only('schema', 'name', 'module_type');
          $tableName =  $module . 's';
          $foreignKey =  $module . '_id';
          $pivotTableName =  $module . '_language';
          $pivotSchema = $this->pivotSchema($tableName, $foreignKey, $pivotTableName);
          $migrationPivotFileName = date('Y_m_d_His', time() + 10) . '_' . 'create_' . $pivotTableName . '_table.php';
          $migrationPivotPath = database_path('migrations/' . $migrationPivotFileName);
          $migrationPivotTemplate = $this->createMainTable([
               'schema' => $pivotSchema,
               'name' =>   $pivotTableName,
          ], $pivotTableName);
          FILE::put($migrationPivotPath, $migrationPivotTemplate);
}
     private function makeMainTable($request,$module){
          $payload = $request->only('schema', 'name', 'module_type');
          $tableName = $module. 's';
          $migrationFileName = date('Y_m_d_His') . '_' . 'create_' . $tableName . '_table.php';
          $migrationPath = database_path('migrations/' . $migrationFileName);
          $migrationTemplate = $this->createMainTable($payload, $tableName);

          FILE::put($migrationPath, $migrationTemplate);
     }
     private function relationSchema($module)
     {
          $relationSchema = <<<SCHEMA
          Schema::create('{$module}_catalogue_{$module}', function (Blueprint \$table) {
            \$table->unsignedBigInteger('{$module}_catalogue_id');
            \$table->unsignedBigInteger('{$module}_id');
            \$table->foreign('{$module}_catalogue_id')->references('id')->on('{$module}_catalogues')->omDelete('cascade');;
            \$table->foreign('{$module}_id')->references('id')->on('{$module}s')->omDelete('cascade');
        });
SCHEMA;
return $relationSchema;
     }
     private function pivotSchema($tableName = '', $foreignKey = '', $pivotTableName = '')
     {
          $pivotSchema  = <<<SCHEMA
        Schema::create('{$pivotTableName}', function (Blueprint \$table) {
            \$table->unsignedBigInteger('{$foreignKey}');
            \$table->unsignedBigInteger('language_id');
            \$table->foreign('{$foreignKey}')->references('id')->on('{$tableName}')->omDelete('cascade');
            \$table->foreign('language_id')->references('id')->on('languages')->omDelete('cascade');
            \$table->string('name');
            \$table->text('description');
            \$table->string('canonical')->unique();
            \$table->longText('content')->nullable();
            \$table->string('meta_title')->nullable();
            \$table->string('meta_keyword')->nullable();
            \$table->text('meta_description')->nullable();
            \$table->timestamps();
        });
SCHEMA;
          return $pivotSchema;
     }

     private function createMainTable($payload, $tableName)
     {
          $migrationTemplate =  <<<MIGRATION
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     {$payload['schema']}
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('{$tableName}');
    }
};

MIGRATION;
          return $migrationTemplate;
     }


     private function convertModuleNameToTableName($name)
     {
          $temp = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name));
          return $temp;
     }


     private function makeController($request)
     {
          $payload = $request->only('name', 'module_type');
          switch ($payload['module_type']) {
               case 1:
                    $this->createTemplateController($payload['name'], 'TemplateCatalogueController');
                    break;
               case 2:
                    $this->createTemplateController($payload['name'], 'TemplateController');
                    break;
               default:
                    //    $this->createSingleController();
                    break;
          }
     }

     private function createTemplateController($name, $templateName)
     {
          try {
               $controllerName = $name . 'Controller.php';
               $templateControllerPath = base_path('app/Template/' . $templateName . '.php');
               $controllerContent = file_get_contents($templateControllerPath);

               $replace = [
                    'ModuleTemplate' => $name,
                    'moduleTemplate' => lcfirst($name),
                    'foreignKey' => $this->convertModuleNameToTableName($name) . '_catalogue_id',
                    'tableName' => $this->convertModuleNameToTableName($name) . '_catalogues',
                    'moduleView' => str_replace('_', '.', $this->convertModuleNameToTableName($name))
               ];
               $controllerContent = str_replace('{ModuleTemplate}', $replace['ModuleTemplate'], $controllerContent);
               $controllerContent = str_replace('{moduleTemplate}', $replace['moduleTemplate'], $controllerContent);
               $controllerContent = str_replace('{foreignKey}', $replace['foreignKey'], $controllerContent);
               $controllerContent = str_replace('{moduleView}', $replace['moduleView'], $controllerContent);
               $controllerContent = str_replace('{tableName}', $replace['tableName'], $controllerContent);

               $controllerPath = base_path('app/Http/Controllers/Backend/' . $controllerName);
               FILE::put($controllerPath, $controllerContent);
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               return false;
          }
     }

     private function makeModel($request)
     {
          try {
               if ($request->input('module_type') == 1) {
                    $this->createCatalogueModel($request);
               }else if ($request->input('module_type') ==2){
                    $this->createModel($request);
               }else {
                    echo 123;die();
               }
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               return false;
          }
     }
 private function createModel($request){
          $modelName = $request->input('name');
          $templateModelPath = base_path('app/Template/models/Post.php');
          $modelContent = file_get_contents($templateModelPath);
          $replace = [
               'Module' => $modelName,
               'module' =>  lcfirst($modelName),
          ];
          foreach ($replace as $key => $value) {
               $modelContent = str_replace('{' . $key . '}', $replace[$key], $modelContent);
          }
          $modelPath = base_path('app/Models/' . $modelName . '.php');
          FILE::put($modelPath, $modelContent);
 }
     private function createCatalogueModel($request)
     {
          $modelName = $request->input('name');
          $templateModelPath = base_path('app/Template/models/PostCatalogue.php');
          $modelContent = file_get_contents($templateModelPath);
          $module = $this->convertModuleNameToTableName($request->input('name'));
          $extractModule = explode('_', $module);
          $replace = [
               'Module' => ucfirst($extractModule[0]),
               'module' =>  $extractModule[0],
          ];
          foreach ($replace as $key => $value) {
               $modelContent = str_replace('{' . $key . '}', $replace[$key], $modelContent);
          }


          $modelPath = base_path('app/Models/' . $modelName . '.php');
          FILE::put($modelPath, $modelContent);
     }

     private function makeRepository($request)
     {
          $name = $request->input('name');
          $module = $this->convertModuleNameToTableName($name);
          $moduleExtract = explode('_', $module);
          $option = [
               'repositoryName' => $name . 'Repository',
               'repositoryInterfaceName' => $name . 'RepositoryInterface',
          ];

          $repositoryInterface =  base_path('app/Template/TemplateRepositoryInterface.php');
          $repositoryInterfaceContents = file_get_contents($repositoryInterface);
          $replace = [
               'Module' => $name,

          ];
          $repositoryInterfaceContents = str_replace('{Module}', $replace['Module'], $repositoryInterfaceContents);

          $repositoryInterfacePath = base_path('app/Repositories/Interfaces/' . $option['repositoryInterfaceName'] . '.php');



          $repository =  base_path('app/Template/TemplateRepository.php');
          $repositoryContents = file_get_contents($repository);
          $replaceRepository = [
               'tableName' => $module . 's',
               'Module' => $name,
               'pivotTableName' => $module . '_language' ,
               'foreignKey' => $module . '_id'
          ];
          foreach ($replaceRepository as $key => $value) {
               $repositoryContents = str_replace('{'.$key.'}', $replaceRepository[$key], $repositoryContents);
          }
          $repositoryPath = base_path('app/Repositories/' . $option['repositoryName'] . '.php');
          FILE::put($repositoryPath, $repositoryContents);
          FILE::put($repositoryInterfacePath, $repositoryInterfaceContents);
     }


     private function makeService($request)
     {
          $name = $request->input('name');
          $module = $this->convertModuleNameToTableName($name);
          $moduleExtract = explode('_', $module);
          $option = [
               'ServiceName' => $name . 'Service',
               'ServiceInterfaceName' => $name . 'ServiceInterface',
          ];

          $ServiceInterface =  base_path('app/Template/TemplateServiceInterface.php');
          $ServiceInterfaceContents = file_get_contents($ServiceInterface);
          $replace = [
               'Module' => $name,

          ];
          $ServiceInterfaceContents = str_replace('{Module}', $replace['Module'], $ServiceInterfaceContents);

          $ServiceInterfacePath = base_path('app/Services/Interfaces/' . $option['ServiceInterfaceName'] . '.php');

          FILE::put($ServiceInterfacePath, $ServiceInterfaceContents);


          $Service =  base_path('app/Template/TemplateService.php');
          $ServiceContents = file_get_contents($Service);
          $replaceService = [
               'Module' => $name,
               'tableName' => $module . 's',
               'pivotTableName' => $module . '_' . $moduleExtract[0],
               'foreignKey' => $module . '_id',
               'relationTableName' => $module . '_language',
               'module' => lcfirst($name)
          ];
          foreach ($replaceService as $key => $value) {
               $ServiceContents = str_replace('{' . $key . '}', $replaceService[$key], $ServiceContents);
          }

          $ServicePath = base_path('app/Services/' . $option['ServiceName'] . '.php');
          FILE::put($ServicePath, $ServiceContents);
     }



     public function update($id, $request)
     {
          DB::beginTransaction();
          try {
               $payload = $request->except(['_token', 'send']);

               $user = $this->GenerateRepository->update($id, $payload);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               return false;
          }
     }

     public function destroy($id)
     {
          DB::beginTransaction();
          try {
               $user = $this->GenerateRepository->destroy($id);

               DB::commit();
               return true;
          } catch (Exception $e) {
               DB::rollBack();
               echo $e->getMessage();
               die();
               return false;
          }
     }
}
