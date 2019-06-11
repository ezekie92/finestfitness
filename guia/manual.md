# Manual de usuario

##Administrador

###Horarios
El administrador tiene acceso al horario del gimnasio, así como a la edición del mismo.

Clicando en el nombre del día el cual desea modificar, le redirige a un formulario donde podrá establecer los nuevos datos.
![horario](images/horario.png)
![horario_modificar](images/horario_modificar.png)


###Tarifas
El administrador puede ver un listado de tarifas y filtrar por los datos que desee.
![tarifa](images/tarifa.png)


También puede crear una nueva clicando en el botón *Añadir tarifa*
![tarifa_crear](images/tarifa_crear.png)


También puede ver el detalle de una tarifa clicando en el icono de la derecha de la fila deseada en la vista *index* de tarifas.
![tarifa_ver](images/tarifa_ver.png)


###Clases
El administrador puede elegir si ir al index de clases o al calendario.
![clases_menu](images/clases_menu.png)


En el calendario verá un calendario semanal, puedo ser un calendario diario, de las clases que hay en la semana actual. Si clica en una clase, filtra por todas la clases de ese tipo.
![clases_cal](images/clases_cal.png)


Si accede al index, verá un listado de las clases que hay, puedo filtrar por el criterio deseado, así como ver el detalle, crear una nueva clase, modificar una actual por completo o modificar sólo al monitor.
![clases_index](images/clases_index.png)


Si crea una nueva clase tendrá que pasarle los datos que vemos en la siguiente imagen.
![clases_crear](images/clases_crear.png)


Para modificar una clase existente tendrá que modifcar un formulario muy similar al anterior, pero si sólo quiere asignar otro monitor, lo podrá hacer clicando en el primer icono que vemos en la fila *(sombrerito)* y lo hará en la siguiente ventanda modal
![clases_monitor](images/clases_monitor.png)


###Entrenos
En entrenos *(entrenamientos)* podrán ver los entrenamientos solicitados por los clientes, así como el estado, el cual hace cambiar el color de la fila en cuestión para una poder diferenciarlos rápidamente.
![entrenos](images/entrenos.png)


###Administradores
Al acceder a administradores tienen dos opciones, dar de alta o gestionar (mismo menú desplegable que en clases).
Si deciden gestionar, verán un index con los datos de los administradores.
![admin_index](images/admin_index.png)


Si dedicen dar de alta, tendrán que rellenar el siguiente formulario.
![admin_crear](images/admin_crear.png)


Más adelante veremos qué pasa cuando se da de alta a un usuario, sea del tipo que sea.


###Monitores
Aquí el administrador vuelve a tener un menú desplegable, donde puede ver el index, dar de alta a un monitor o ver las especialidades que podrían tener los monitores.
![monitor_index](images/monitor_index.png)
![monitor_crear](images/monitor_crear.png)


Si clican en perfil, pueden ver el perfil de este
![monitor_ver](images/monitor_ver.png)

También pueden darlo de baja, modificar sus datos o convertirlo en cliente clicando en el botón *convertir*;
Al clicar en convertir te pide confirmación y en caso de aceptar te muestra el siguiente formulario (el resto de datos ya los coge automáticamente)
![monitor_convertir](images/monitor_convertir.png)


En caso de llevar a cabo con éxito la conversión, mostraría un mensaje confirmándolo, pero si el monitor tiene clases asignadas, tendría que asignar otro monitor a sus clases y luego realizar la conversión
![monitor_fallo](images/monitor_fallo.png)



Si acceden a especialidad, ven un index de especialidades, y pueden tanto editar la especialidad que deseen *(editaría el nombre de la especialidad)*, como crear nuevas especialidades.
![esp_index](images/esp_index.png)


###Clientes
Vuelve a tener un menú desplegable de opciones.
Con un gestionar prácticamente idéntico al de monitor, mismas funciones, ver perfil, modificar, dar de baja y convertir.
En ese caso, al convertir si el cliente estuviese inscrito a alguna clase, o tuviese entrenamientos, estos se cancelan directamente.
Si accede al perfil del cliente, puede además cambiar la tarifa de este, o ingresar un pago realizado en mano en caso de que el cliente olvidase pasar la última mensualidad.
En caso de ingresar un pago realizado en mano, se mostraría un formulario solicitando el concepto y la cantidad
![cliente_ver](images/cliente_ver.png)
![cliente_pago](images/cliente_pago.png)

Para cambiar la tarifa simplemente se le mostrará un formulario con un único campo desplegable que muestra todas las tarifas, seleccionaría la nueva tarifa y se realizaría el cambio
![cliente_tarifa](images/cliente_tarifa.png)


Otras funciones respecto a los clientes sería ver una tabla con todos los clientes inscritos a clases. Y poder filtrar por cliente o por clase.
![cliente_clase](images/cliente_clase.png)


Así como ver los pagos que han realizado todos los clientes y filtrar por el criterio deseado.
![pagos](images/pagos.png)


##Monitor
El monitor sólo tiene acceso a clases y entrenamientos.
En lo que a clases se refiere, puede ver el index de clases visto anteriormente, el calendario, y una vista llamada mis clases dónde se le mostrarían todas las clases en las que él esté asignado como monitor.

En cuanto a entrenamientos, puede ver el calendario o un índice con los entrenamientos que él haya aceptado, además permitirle aceptar o rechazar entrenamientos
![ent_solicitud](images/ent_solicitud.png)

En caso de aceptar o rechazar se le notifica la acción realizada
![ent_msg](images/ent_msg.png)


##Cliente
Los clientes tienen las opciones ya vistas de ver el index o el calendario de clases.
Solo que en su caso, ellos pueden inscribirse ocupando una plaza, o decidir no asistir desocupando esa plaza
![clt_clases](images/clt_clases.png)


En cuanto a entrenamientos, ven un index de entrenamientos los cuales han solicitado y han sido aceptados por el monitor en cuestión.
Para solicitar un entrenamiento, lo hacen mediante una de las opciones desplegables del menú de navegación
Y en la vista siguiente verían detalles del monitor y la opción de solicitar que ser entrenado
![clt_solicitar](images/clt_solicitar.png)
![clt_solicitud](images/clt_solicitud.png)


Una opción exclusiva de clientes es la de crear rutinas
El cliente crearía una rutina asignandole un nombre y luego podrá ir añadiéndole ejercicios
![rutina](images/rutina.png)

Cuando accede al detalle de la rutina, podrá añadir ejercicios o ver los que ya la componen
![rutina_ej](images/rutina_ej.png)


Si desea añadir ejercicios a la rutina, lo podrá hacer mendiante el siguiente formulario
![ej_crear](images/ej_crear.png)




##Todos los usuarios
Los usuarios cuentan con la opción alternar entre modo noche/dia clicando en el símbolo que ven a la derecha de su pantalla.
Si cierran el navegador en modo noche, la próxima vez que entren verán la app en modo noche, ya que este valor se guarda en almacenamiento local
![noche](images/noche.png)

Cuando un usuario es dado de alta recibe un email de confirmación, el cual le redirige a la app y le solicita la contraseña, una vez establecida, ya puede acceder a la app usando su correo y contraseña.
