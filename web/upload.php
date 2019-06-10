<?php

require '../vendor/autoload.php';

use Aws\S3\S3Client;

/**
 * Sube una imagen a AWS S3.
 * @param string $foto   El nombre de la foto
 * @return mixed
 */
function subir($foto)
{
    $s3 = new S3Client([
    'region' => 'eu-west-3',
    'version' => 'latest',
    'credentials' => [
        'key' => getenv('S3KEY'),
        'secret' => getenv('S3SECRET'),
    ],
    ]);

    isset($_FILES['Clientes']['tmp_name']['foto']) ? $file = $_FILES['Clientes']['tmp_name']['foto'] : $file = $_FILES['Monitores']['tmp_name']['foto'];

    $result = $s3->putObject([
    'Bucket' => getenv('BUCKET'),
    'Key' => $foto,
    'SourceFile' => $file,
    ]);
}

/**
 * Borra una imagen de AWS S3.
 * @param string $foto   El nombre de la foto
 * @return mixed
 */
function borrar($foto)
{
    $s3 = S3Client::factory(
        [
            'region' => 'eu-west-3',
            'version' => 'latest',
            'credentials' => [
                'key' => getenv('S3KEY'),
                'secret' => getenv('S3SECRET'),
            ],
        ]
    );

    $s3->deleteObject([
        'Bucket' => getenv('BUCKET'),
        'Key' => $foto,
    ]);
}
