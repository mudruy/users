users mongo bundle
=====

Symfony 2.8

запуск проекта php app/console cache:clear;php app/console server:run
посмотреть можно http://localhost:8000/
после запуска надо зарегистрировать пользователя, он будет с правами пользователя
потом в админке поменять ему права андминистратора
затем в app/config/security.yml повысить уровень доступа 
- { path: ^/, roles: ROLE_USER  } => - { path: ^/, roles: ROLE_ADMIN  }
для полноценной работы в mongo надо создать индекс в коллекции users по полю name

реализована регистрация, аутефикация, CRUD 
пользователи храняться в MongoDB
криптование пароля bcrypt
использовано Symfony Forms, Doctrine MongoDB ODM
Bootstrap из интеренета бесплатный
