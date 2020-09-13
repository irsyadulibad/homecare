<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Homecare</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/components.css'); ?>">
</head>
<body>
<?php if($swal = $this->session->flashdata('swal')): ?>
  <div id="swal" data-type="<?= $swal['type'] ; ?>" data-msg="<?= $swal['msg']; ?>"></div>
<?php else: ?>
  <div id="swal" data-type="" data-msg=""></div>
<?php endif; ?>
  <div id="app">
  
