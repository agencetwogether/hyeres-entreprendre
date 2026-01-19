@extends('errors::layout')

@section('title', __('app.pages.errors.401.title'))
@section('code', '401')
@section('description', __('app.pages.errors.401.description'))
@section('message', __('app.pages.errors.401.message'))
@section('level', 'danger')
@section('action_return', filament()->getUrl())
