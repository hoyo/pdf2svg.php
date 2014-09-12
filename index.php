<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim(['templates.path' => 'templates']);

$app->get('/', function () use ($app) {
  $app->render('form.php');
});

$app->post('/', function () use ($app) {
  $source = $app->request->post('source');
  if (empty($source)) {
    exit('Error: parameter "pdf" is required');
  }
  if (!preg_match('/^https?:.*\.pdf$/i', $source)) {
    exit('Error: parameter "pdf" must be pdf format');
  }

  // 一意に特定できる文字列を生成
  $factory = new \RandomLib\Factory;
  $generator = $factory->getMediumStrengthGenerator();
  $title = date('YmdHis_') . $generator->generateString(8, 'abcdef');

  // PDFをローカルに保存
  $pdf = @file_get_contents($source);
  if (empty($pdf)) {
    exit('Error: pdf file is not found');
  }
  file_put_contents("cache/$title.pdf", $pdf);

  // SVGに変換
  exec("cd cache; pdf2svg $title.pdf $title-%d.svg all");

  $deck = glob("cache/$title-*.svg");
  if (empty($deck)) {
    exit('Error: failed to convert pdf');
  }

  $app->render('viewer.php', ['deck' => $deck]);
});

$app->run();
