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

# to only include some functions in resourceful routing
Route::resource('/products',ProductController::class)->only('index','show');

# If additional functions are used inside a resource controller 
Route::get('/products/search',[ProductController::class,'search'])->name('products.search');

# localScope can be used for the queries that are used more 
we use it inside the model and have name of scopeName
- local scope allow you to define common sets of query constraints that you may easily re-use throughout application
- Mostly used for search purposes.
- They return query builder instance. 
## to define a scope we prefix and eloquent model method with scope eg scopeSearch.


# Global scopes
- They are different that global scopes which allow to add constraints to all queries for a given model.It makes sure that every query for a given model receives certain constraints
- They are defined by implementing Scoepe and applied inside a model by using booted() function

# For order 
### For state management we use sessions
Add to cart
-> if order is not create create an order
-> store that order_id in session
-> create order_item having order_id of the status
-> for one session create one order and then add order_items when navigating to different places and adding products
-> update order_table with total from order_items
Order{
    order_id = 1,
    user_id = 1,
    order_status = cart,
    sub_total = 1100,
    shipping_price = 100,
    discount = 50,
    total = 1150,
    shipping_address = Bhaktapur
}

Order_items(
    {
        order_id = 1,
        id = 1,
        product_id = 1,
        price = 100,
        quantity = 2,
        total = 200
    },
    {
        order_id = 1,
        id = 2,
        product_id = 3,
        price = 200,
        quantity = 3,
        total = 600
    },
    {
        order_id = 1,
        id = 3,
        product_id = 6,
        price = 100,
        quantity = 3,
        total = 300
    }
)

when add to cart is clicked firstly we check for data i-e order_id in session, if not present create a new order else add order items to same order

# Authorization using gates and policies
- Laravel provides two primary ways of authorizing actions: gates and policies. Think of gates and policies like routes and controllers. Gates provide a simple, closure-based approach to authorization while policies, like controllers, group logic around a particular model or resource. In this documentation, we'll explore gates first and then examine policies.
- You do not need to choose between exclusively using gates or exclusively using policies when building an application. Most applications will most likely contain some mixture of gates and policies, and that is perfectly fine!
- Gates are most applicable to actions which are not related to any model or resource, such as viewing an administrator dashboard. In contrast, policies should be used when you wish to authorize an action for a particular model or resource.

- We use authorization so that the user who created the products or posts can only modify and delete it . 

- We define gates in authserviceprovider class
- If we want to add a new foreignKey we can set a default value to avoid errors

- We use the @can() function to see if the user can update the product or not, when this function is encountered control is transferred to the authserviceprovider class where we write main logic for authorization using gates

we also check for authorization in controller and if the user is not authorized it gives 403 forbidden

we can also use Gate::authorize method for same purpose

# Instead of gates we can also use policies which can be created using php artisan make:policy
defining gates directly in auth service provider is same as using functions in routes and defining function in policy is same as defining functions in a controller.
convention: PascalCase ModelnamePolicy

Then we define policies in authserviceprovider