Para que no te tengas que leer todo el documento para coger los datos de acceso
a mysql, redis y load balancer te lo pongo aqui:

mysql: ec2-54-171-169-155.eu-west-1.compute.amazonaws.com
user: root
password: root

redis: ec2-176-34-134-152.eu-west-1.compute.amazonaws.com
user: root
password: (no hay password)

Puedes conectarte desde fuera, para mysql uso el workbench y para redis,
el redis desktop manager.

El dominio para entrar a la web via loadbalancer es:

http://practicaperformance-341312800.eu-west-1.elb.amazonaws.com/blog/current/application/web/

El archivo para hacer los deploy en amazon lo saco, porque creo que no debería estar por seguridad,
si lo quisieses para hacer pruebas me lo pides. 

