users mongo bundle
=====

Symfony 2.8

git clone https://github.com/mudruy/tracker.git . <br />
wget https://getcomposer.org/download/1.0.0-alpha11/composer.phar <br />
php composer.phar update <br />

Должна быть запущена монго, без аутефикации с локалхоста. <br />
Или настроить доступы в конфиге app/config/config.yml <br />

забрасываем фиктуры php app/console doctrine:mongodb:fixtures:load <br />


Запускаем веб сервер тестовый <br />
app/console cache:clear;php app/console server:run <br />
посмотреть можно http://localhost:8000/ <br />

Запустить тест можно
./bin/phpunit -c app/ src/Acme/UsersBundle/Tests/

администаратор пользователей admin:admin <br />

в app/config/security.yml можно управлять уровенем доступа  <br />
- { path: ^/, roles: ROLE_USER  } => - { path: ^/, roles: ROLE_ADMIN  } <br />
для полноценной работы в mongo надо создать индекс в коллекции users по полю name <br />

реализована регистрация, аутефикация, CRUD <br /> 
пользователи храняться в MongoDB <br />
криптование пароля bcrypt <br />
использовано Symfony Forms, Doctrine MongoDB ODM <br />
Bootstrap из интеренета бесплатный <br />
