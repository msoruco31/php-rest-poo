README PRUEBA YAPO

-REQUISITOS

    PHP 5.4 o superior
    Librería SQLite3, php-sqlite

- INSTALACIÓN

	git clone https://gitlab.com/msoruco31/prueba-yapo
	
    Si solicita el password, Pulsar ENTER ya que el proyecto se encuentra público.

    Este proyecto utiliza una base de datos embebida (SQLITE3) cuyo path se encuentra en bd/user.db

- SERVIDOR BUILT IN

	Una vez descargados los fuentes desde el repositorio. Dentro carpeta principal del proyecto (prueba-yapo) se debe levantar el servidor con el siguiente comando:
	
	php -S {IP o localhost}:8000 
	Ejemplo: php -S localhost:8000

- WEB

    - URL: http://{IP o localhost}:8000

-  API
    - Credenciales para autentificación Básica:
        User: admin
        Password: Franco3119
	
    - GET:
        - URL: http://{IP o localhost}:8000/api/user/{USERNAME (opcional)}
        - BODY: No Aplica   
    
    
    - POST:
    	- URL: http://{IP o localhost}:8000/api/user
        - BODY: Formato Json
        	{
				"username":"{NOMBRE_USUARIO}",
				"password":"{PASSWORD}",
				"roles":"{ROLES (separados por ",")}"   	Ejemplo: "roles":"1,2,3,admin"
			}        

    
    - PUT: 
    	- URL: http://{IP o localhost}:8000/api/user
        - BODY: Formato Json
        	{
				"username":"{NOMBRE_USUARIO}",
				"password":"{PASSWORD}",
				"roles":"{ROLES (separados por ",")}"   	Ejemplo: "roles":"1,3"
			}
        
    
    - DELETE:
    	- URL: http://{IP o localhost}:8000/api/user/{username}
        - BODY: No Aplica


    - USUARIOS PRUEBA:

        USERNAME    |ROLES      |   PASSWORD
        
        admin       |1,2,3,admin|Franco3119
        
        cvasquez    |1,2        |Franco1631
        
        msoruco     |1,3        |Franco3119
        
        user1       |2,3        |user1

        

