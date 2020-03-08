# simplified-laravel-model
a simplified laravel-based Model class that can be used to assist with your OOP PHP project

*examples may be found in [models/test.php](https://github.com/Waabuffet/laravel-simplified-model/blob/master/models/test.php)*

this example has a simplified music school database with a 'sessions' table having foreign keys to all other tables (students, teachers, rooms, instruments)

***make sure to fill your database name, username and password in [models/DB](https://github.com/Waabuffet/laravel-simplified-model/blob/master/models/DB.php)***

## if you are not familiar with laravel

### properties

- at any moment, you can directly get the column name of any object to retrieve its value
example: `$student->lastName`

- you can also set the property
example: `$student->phone_number = '123123'`

### static methods

- `all()` will retrieve all data of an object and return an array of instances

- `find($id)` will return an instance of the object that has the specified id

- `where($column, $operator, $value)` will return an instance or array of instances based on the conditions specified

- `insert($params)` will insert the object (key => value) in the respective db table and return an instance of that object

### instance methods

- `save()` should be called after creating an empty instance and filling its properties. it will save the object in the db table

- `update($params)` should be called on an existing instance, you can update any property in the db table

- `delete()` will delete the db record and destroy the used instance

### relational methods

the following methods should be used inside your children of Model classes to mark the relationship between each other

- **ONE TO ONE** `belongsTo(Classname.class)` indicates that the model we are working with has a foreign key pointing to another model. This will return one instance of the other model
example from the music school: when working with a session, we can know which student it has by calling `$session->student()` after defining the student relationship method inside *StudenSession*

- **ONE TO MANY | MANY TO ONE** `hasMany(Classname.class)` indicates that the model we are specifing in the argument has a foreign key of the model we are working with. This will return an array of instances of the other model.
example from the music school: when working with a teacher, we need to know the sessions he is giving by calling `$teacher->sessions()` after defining the studentSession relationship method inside *Teacher*

- **MANY TO MANY** `belongsToMany(Classname.class, PivotClassname.class)` indicates that the model we are working with and the specified model have a pivot table which we specify its model in the second argument. This will return an array of instances of the other model.
example from the music school: we need to know the students that a teacher gives sessions to by calling `$teacher->students()` after defining the students relationship method inside *Teacher*