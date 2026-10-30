@extends('errors.layout')

@section('code', '429')
@section('icon', 'bi-stopwatch')
@section('title', 'Demasiados intentos')
@section('message', 'Has realizado demasiados intentos seguidos. Espera un minuto y vuelve a intentarlo.')