@extends('layouts.master')
@section('content')
    <main role="main" class="container">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h1><?php echo __('404 Fehler', 'theme'); ?></h1>
                    <p><?php echo __('Die gesuchte Seite wurde nicht gefunden', 'theme'); ?></p>
                    <a href="/" target="_self" class="button button--primary"><span><?php echo __('Zur Startseite', 'theme'); ?></span></a>
                </div>
            </div>
        </div>
    </main>
@stop
