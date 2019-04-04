# Descripción general del proyecto

Aplicación para la gestión de entrenadores, clases y clientes de un gimnasio por parte del administrador.

Los clientes, una vez registrados, tienen acceso a la aplicación y pueden consultar las rutinas propuestas por el gimnasio, las suyas propias, solicitar un entrenador personal y realizar el pago de las mensualidades.

Los entrenadores también tendrán acceso a la aplicación, y podrán ver las clases que imparten, los clientes a los que entrenan, etc. Todo esto en un calendario semanal/mensual fácil de entender.

## Funcionalidad principal de la aplicación

El administrador es quien da de alta a nuevos clientes y nuevos entrenadores, para que sólo los usuarios del gimnasio tengan acceso a la aplicación.


Los clientes cuando acceden a la app ven varias secciones:
* Rutinas generales
* Mis rutinas
* Clases
* Entrenadores
* Perfil


En el apartado Clases el cliente accederá a un calendario que puede ser semanal o mensual, en el que se visualizarán los datos relevantes de cada clase. El cliente podrá inscribirse siempre que haya hueco disponible.


En el apartado Entrenadores podrá ver una lista de los entrenadores que tiene el gimnasio, ver su perfil y solicitar una sesión de entrenamento. Dicha solicitud tiene que ser aceptada por el entrenador o el administrador.


Los entrenadores cuando acceden a la app verían algo similar a lo siguiente:
* Mis clases
* Clientes
* Mis rutinas
* Perfil

El entrenador puede clicar en el nombre de un cliente al que entrene y verá parte de su perfil, así como datos relacionados con la resión de entrenamiento.
También puede clicar en el nombre de una clase para ver el calendario de esas clases.


El gimnasio cuenta con un horario para cada día de la semana, los clientes no podrán tener horarios de entrada fuera de los horarios del gimnasio, tampoco se podrán crear clases que empiecen o terminen fuera de dicho horario.

Los clientes no pueden inscribirse a una clase que empiece antes de su horario de entrada.


Un cliente puede pasar a ser entrenador y viceversa, sería el administrador quien realizaría esta acción.


Las rutinas generales son creadas por el administrador.


Una persona no puede ser cliente y entrenador a la vez.


Un cliente no puede inscribirse a dos clases que coincidan en horario. Un cliente no puede inscribirse a una clase si ya tiene un entrenamiento (con el entrenador) asignado que coincida con la hora de la clase.


Un entrenador no puede impartir dos clases que coincidan en horario. Un entrenador no puede impartir una clase y entrenar a un alumno al mismo tiempo.


Las clases son creadas por el administrador, que es quien asigna al entrenador.


Cada cliente pagará una mensualidad en función de la tarifa seleccionada. Las tarifas dependen de factores como la edad y el horario.


La tarifa es elegida por el cliente, pero es aplicada por el administrador, para que un cliente pueda cambiar de tarifa, tendrá que hablar con el administrador y es este será quien realice el cambio.

## Objetivos generales

* Gestionar los clientes.
* Gestionar los entrenadores.
* Gestionar las clases.
* Gestionar los entrenamientos
* Gestionar las rutinas.
* Gestionar los horarios.
* Gestionar las mensualidades.


## URL del repositorio

[https://github.com/ezekie92/finestfitness](https://github.com/ezekie92/finestfitness)

## URL de la documentación

[https://ezekie92.github.io/finestfitness/](https://ezekie92.github.io/finestfitness/)
