@extends('errors::layout')

@section('title', __('app.pages.errors.404.title'))
@section('code', '404')
@section('description', __('app.pages.errors.404.description'))
@section('message', __('app.pages.errors.404.message'))
@section('level', 'primary')
@section('action_return', filament()->getUrl())

