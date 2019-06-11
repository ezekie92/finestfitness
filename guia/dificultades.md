
# Dificultades encontradas

La primera dificultad surgió al crear la BD, necesitaba tres tipos de usuarios, pero pensé que podría incluirlos en una sola tabla. Llegado cierto punto, esto se hizo inviable y tuve que dividir esa tabla en tres.

La siguiente dificultad fue el poder iniciar sesión, por tener más de un tipo de usuario en la aplicación. Lo primero que pensé fue crear una tabla donde se almacenase un id que apuntase al id del usuario en cuestión, pero quería mostrar el nombre del usuario logueado, no su id, así que tras buscar información y meditarlo, decidí optar por crear un modelo, el cual definí como el *Identity Class* de la aplicación, que se encargase de distinguir el tipo de usuario que se loguea (a partir de su email), para así tomar los datos de la tabla correspondiente.

Quería incluir un calendario para las *issues*

 - [# (R66) Ver todo
   entrenador](https://github.com/ezekie92/finestfitness/issues/66)

 - [# (R78) Ver clases
   cliente](https://github.com/ezekie92/finestfitness/issues/78)

Y pese a que habían muchas librerías y widgets, no conseguía hacer funcionar ninguno, por más que siguiese la documentación oficial, o la guía de algún foro. Finalmente pude utilizar [FullCalendar](https://fullcalendar.io/), pero conllevó volver a cambiar la base de datos, ya que la manera de almacenar el día, inicio y final de las clases/entrenamientos no resultaba compatible con los datos que tenía que pasarle a la configuración del script.

### Uso de Amazon S3
- Pese a que no lo considero algo realmente importante en este tipo proyecto, me parecía que, el incluir imágenes, podría resultar interesante. Frente a otras opciones, como Dropbox, esta me parecía la más potente de cara a la escalabilidad del proyecto.
- Quizá la principal dificultad aquí fue el encontrar la documentación concisa y  actualizada.

### Uso de PayPal
 - Decidí incluir una pasarela de pago mediante PayPal para realizar el pago de las mensualidades del gimnasio. Recayendo la responsabilidad de realizar el susodicho sobre el cliente. Me decanté por PayPal por ser una gran alternativa a los bancos, y por la facilidad de uso como cliente.
 - Aquí apenas encontré dificultades para su uso. Fue más difícil la logística derivada de la gestión de pagos, que el uso de la API de PayPal,


 **En resumen:** los cambios a la base de datos, seguramente por un mal planteamiento inicial, ha resultado ser lo que más problemas me ha causado.
