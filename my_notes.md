## what are database seeders?
=> migrate:fresh or refresh will cause loss of data as it rollbacks all the tables so we use database seeding to avoid such loss of data 
it is found in database/seeders
php artisan db:seed to seed the database with records 
we can use php artisan migrate:fresh --seed to seed the database after migrating automatically
# first method for database seeding is by creating the seed directly in the seeder file
# another and preferred method is by using factories 
# in default factory file of user faker class is used which is used to create fake or random names and emails 
# for creating factories from command
php artisan make:factory <factory_name>
here factory_name uses PascalCase
In factory class we use the faker class to create fake data and run the factory using seeder

# we use fillable for mass assigned i-e using ::create() function is we add any column that is not included in the fillables it will give error but when we use save() method to create the row we don't need to include the column in fillables.
# create() method is called multi assignment as we can pass the arrays and can create mass data at once and it will only take fillable properties 
# so seeder doesn't use the create method but uses save method instead 

# in frontend the path of css,js and images if not specified in public generally refers to their parent i-e incase of localhost/product it will seach for files in / so if we add /css /js /images it will refer to the root and hence localhost/product/1 will also work

# factories and seeders are generally used for testing purposes to generate test data

#clockwork is a composer package used for debugging purpose
n+1 problem occurs when many sql queries run behind the scene which affects the performance 

=> this problem occurs when we try to access a certain data that has relationship between two different table so if with() is not used for getting certain data it has to run the query each time for foreign table

When accessing Eloquent relationships as properties, the relationship data is "lazy loaded". Laravel provides eloquent relationships . They allow us to access related models from another model.

But if we're not careful, it's easy to introduce a n + 1 problem - which essentially means that we execute an additional query every time we access the relationship that was not eager loaded .

To illustrate the N + 1 query problem, consider a Post model that is related to User. Let's take a look this example that we have multiple $posts and every post has an user, that we can access with $post->user.

If we did not eager load the user, Laravel will still let us access, but it will execute a query to get it. Now imagine we didn't eager load it and we're doing something like this
https://www.codecheef.org/article/laravel-and-n-1-problem-how-to-fix-n1-problem

To solve this problem we use with(relationship) in the eloquent so it helps us to solve the n+1 problem and improves performance and speed.

# if we explicitly define with in model itself and if we don't need to use the relationship frequently we use without() explicitly for certain cases

# for using foreign keys we need to define relationships in model
here products and categories have a one to many relationship which we define using eloquent in model
A category hasMany products and a product belongsTo category

## components in laravel
they are automatically found in app/View/Components and resource/view/components
php artisan make:component forms/input
we can create components and use it in different files so it increases readability
after registering a component we can use the component using 
<x-componentName/>
we can also pass data to components 
Components can be used to create layouts  

# I will use sections for users and components for admin

## using layouts in bottom up concept and using the components is top-bottom concept 

## for session timeout of token we modify the env file in session_time

Assignments
## form request validation
## update validation 
## delete implementation

testing

# to link storage/ public and public we use 
php artisan storage:link 

# composer require intervention/image for resizing images

# helper functions are the functions that can be accessed from anywhere
create a new file helpers.php in the app folder then add it in composer.json autoload as
"files": [
    "app/helpers.php"
]

# what is this 
# it makes the text written translation ready. In case of many langauges defined in the project it helps in translation and using other languages say converting the text to nepali langauage 
{{ __('Any text')}}

# for using different langaugaes we use the file in resources/lang/ by default en is for english similarly we can use np for nepali. 

Route service provider is the modern way of using routes

# task to create a multi level,category and complete category
