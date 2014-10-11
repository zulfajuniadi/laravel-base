Laravel Jump Start
==================

Takes out the boredom of boiler plating code and provides sensible defaults to jump start Laravel development:

- Authentication: [zizaco/confide]()
- RBAC Authorization: [zizaco/entrust]()
- Model Self Validation: [laravelbook/ardent]()
- Form Class: [anahkiasen/former]()
- Nested Set Class: [baum/baum]()
- Datatables Integration: [bllim/datatables]()
- Excel Import & Exporting: [maatwebsite/excel]()
- Image Manipulation: [intervention/image]()
- Generators: [way/generator]()
- Asset Pipeline: [codesleeve/asset-pipeline]()
- Debugging & Profiler: [itsgoingd/clockwork]()

##Pre-built Stuff

1.  User Management:
    - Login
    - Logout
    - Registration
    - Email confirmation
    - Forgot password
    - User Profile
    - User CRUD for administrator
    - Change password
    - Set password
1.  User's Organisation Unit: All users has one organisation unit. Each organisation units may have many children, and so forth using baum/baum nested set.
1.  Role based access control (RBAC). A user may have many roles. Each roles may have many permissions.
1.  [Datatables]()-based CRUD generator via ``artisan generate:datatable`` command. 
    - Generated models are self-validating and has fine-grained RBAC system.     
    - Generated features handler for both ajax and non-ajax operations, validation and error notifications. 
    - Generated Views features form fields and actions. It extends the way/generator package that generates full CRUD inclusive of:
        - List Page using Ajax Datatables (Support large datasets, pagination, searching, etc)
        - Record Details page
        - Create record page complete with form fields and validation
        - Edit record page complete with form fields and validation
        - Delete record
    - Generated Migrations features all table fields complete with timestamps
    - Generated Database Seeds provides a base to fill in: 
        - Default values for seeding
        - Basic RBAC entries for the model
1.  Uploadable trait. When applied to a model, this enables upload for records of that model.
1.  Artisan app:reset command that does:
    1. Dumps autoload
    1. Clears cache
    1. Resets all migrations
    1. Runs database seeder
    1. Cleans uploads directory


##Minimum Requirements
- PHP 5.4+
- PHP Imagick, PHP Mcrypt
- Redis (Cache, Queues)

##Installation

1.  Create an empty directory and run composer create-project:

    ```
    composer create-project zulfajuniadi/laravel-base .
    ```
1.  Make sure you add your computer's hostname inside the ``bootstrap/start.php`` file like so: 

    ```php
    // L26
    $env = $app->detectEnvironment(array(
      'local' => array('homestead', 'ZulfaJuniadis-MacbookPro.local'),
    ));
    ```
    *You can get your computer's hostname by running ``hostname`` via the terminal or command prompt*


#Usage

##User Management


##CRUD Generator

```bash
artisan generate:datatable --fields="Todo:name:string, Done:is_done:boolean:default(0), User:user_id:integer, Project:project_id:integer" project_todos
```
##Uploadable Trait

The upload able trait enables upload for records of that model. No modifications needed on the database side to enable powerful uploads features.

1. Add ``UploadableTrait`` to model:

    ```php
    // File: models/leaves.php
    
    class Leaves extends Ardent {
      use UploadableTrait;
    ```
1. To display the uploader form in your blade templates:

    ```php
    {{ $leave->yieldUploader(2 /*max size in MB*/, 'image/*' /*file type*/, 5 /*max files*/) }}
    // where $leave is an instance of a Model that has the UploadableTrait
    ```
Other supported filetype arguments: image/*, application/pdf, .psd
1. To display the uploads in your blade templates:

    ```php
    {{ $leave->yieldUploadsTable() }}
    // where $leave is an instance of a Model that has the UploadableTrait
    ```
1. To automatically generate thumbnails for your uploaded image add: ``protected $generate_image_thumbnails = true;`` into the model.
    
#Todos
1.  Unit tests
1.  Reportable trait: Enable model records to be searched & grouped via columns and exported
1.  Graphable trait: Enable graphs and charts to be generated from the model records
1.  Support multi locale
