symfony new users 2.8

# add to composer.json
# "doctrine/mongodb-odm": "~1.0",
#"doctrine/mongodb-odm-bundle": "~3.0"


php composer.phar update doctrine/mongodb-odm doctrine/mongodb-odm-bundle

#db.createUser({user: "user",pwd: "password",roles:[{ role: "readWrite", db: "users" }]})