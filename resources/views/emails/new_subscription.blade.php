@component('mail::message')
    # Nouvel inscrit à la newsletter 🎉

    Laurane, une personne s'est inscrite à votre newsletter : {{ $email }}

    Bonne journée,<br>
    {{ config('app.name') }}
@endcomponent
