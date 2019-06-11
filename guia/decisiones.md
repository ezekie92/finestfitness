# Decisiones adoptadas

### Uso de widgets de Kartik Krajee para Yii2
- Quise agilizar y facilitar el desarrollo de la aplicación, y permitirle al usuario una interacción más agradable con algunos elementos de la app. Por lo que he usado `FileInput` y `DateControl`.

### Cambios en requisitos
- Debido a la evolución de la app, dos requisitos han quedado obsoletos respecto al planteamiento inicial.
   - [# (R58) Ver rutina gimnasio](https://github.com/ezekie92/finestfitness/issues/58) : En un momento de la aplicación, debido a dificultades encontradas, decidí que sólo los clientes podrían crear rutinas. Entonces había que tomar una decisión si quería satisfacer esta *issue*, crear dos tablas para rutinas, crear un cliente ficticio que fuese el propietario de las rutinas creadas por los administradores del gimnasio, o simplemente dejar esta *issue* sin realizar. Decidí esto último ya que las otras dos opciones no me parecían óptimas.
   - [# (R46) Eliminar no confirmados](https://github.com/ezekie92/finestfitness/issues/46) : Esta *issue* se iba a satisfacer en un principio mediante un script de consola, pero debido a que no puedo ejecutarlos desde Heroku, decidí crear una acción en el controlador de clientes que comprobase aquellos no confirmados que llevasen un mes registrados, y ejecutar dicha acción cada vez que se dé de baja a un cliente.
