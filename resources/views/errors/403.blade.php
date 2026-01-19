@extends('errors::layout')

@section('title', __('app.pages.errors.403.title'))
@section('code', '403')
@section('description', __('app.pages.errors.403.description'))
@section('message', __('app.pages.errors.403.message'))
@section('level', 'danger')
@section('action_return', filament()->getUrl())
