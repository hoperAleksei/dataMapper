<?php

//Лабораторная работа №9. Реализация паттерна Repository + DataMapper (2 часа).
//Цель: получить практические навыки реализации DAL (Data Access Layer) через паттерны Repository и Data Mapper.
//Теоретическая часть:
//Постановка задачи: Реализовать простое приложение PHP с доступом в одну из таблиц БД через паттерны Repository и Data Mapper.
//Порядок выполнения:
//Анализ задачи.
//Исследование источников.
//Реализовать преобразование данных таблицы в объект предметной области с помощью паттерна Data Mapper.
//С помощью паттерна Repository реализовать функционал над одной таблицей БД по:
//а). получению всех записей
//б). получению записи по id
//в). получению записей по значению поля из таблицы (фильтрация по полю)
//г). сохранению записи
//д). удалению записи
//Форма отчета: репозиторий на GitHub с php-приложением, работоспособное приложение доступное по сети,
// в котором в качестве DAL используются паттерны Repository и Data Mapper.


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'vendor', 'autoload.php']);
require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'Data.php']);
require_once join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'Repository.php']);




try {
    $dbh = new PDO('mysql:host=localhost;dbname=lab1', 'phplab1', 'phplab1');
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
}

$rep = new DbDateRepository(new DataMapper($dbh));

$type = null;
$id = null;
$message = null;
$res = null;
$d = null;

if (isset($_GET)) {
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
    }
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
    }

    if ($type == 'search') {
        $d = new Data();
        $d->id = $id;
        $d->message = $message;
        $res = $rep->find($d);
    } elseif ($type == 'insert') {
        $d = new Data();
        $d->id = $id;
        $d->message = $message;
        $rep->save($d);
        $res = $rep->findAll();
    } elseif ($type == 'delete') {
        $rep->delete($id);
        $res = $rep->findAll();
    } else
    {
        $res = $rep->findAll();
    }
}


$loader = new \Twig\Loader\FilesystemLoader(join(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'templates']));
$twig = new \Twig\Environment($loader);

$template = $twig->load('index.html.twig');

echo $template->render(['data' => $res]);

