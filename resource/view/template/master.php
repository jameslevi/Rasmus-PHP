<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $emit['title'] }}</title>
</head>
<body class="v-family-sans">

    {{-- This is a sample alert --}}

    <v-alert id="alert_1" scheme="success" variant="default" icon="true" display="true" rounded="true">
        Credentials successfully saved.
    </v-alert>

    <v-alert id="alert_2" scheme="error" variant="border" icon="false" dismiss="true" display="true" rounded="true">
        An error occurred on your request.
    </v-alert>

    <v-alert id="alert_3" scheme="success" variant="outline" size="14" display="true" rounded="true">
        An error occurred on your request.
    </v-alert>
    
    <div>
        {{ $content }}
    </div>

    {{-- This is a comment --}}
</body>
</html>