@extends('errors.layout')

@section('code', '403')
@section('icon', 'bi-shield-lock')
@section('title', 'Acceso denegado')
{{-- Muestra el mensaje enviado con abort(403, '...') en AdminMiddleware --}}
@section('message', $exception->getMessage() ?: 'No tienes permisos para acceder a esta sección.')