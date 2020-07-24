<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>{{ $emit['title'] }}</title>
</head>
<body class="v-family-sans">

    {{-- This is a sample alert --}}

    <v-alert id="alert_1" variant="success" style="default" icon="true" display="true" rounded="true">
        Credentials successfully saved.
    </v-alert>

    <v-alert id="alert_2" variant="error" style="default" icon="true" dismiss="false" display="true">
        An error occurred on your request.
    </v-alert>

    <v-alert id="alert_3" variant="error" style="outline" icon="false" dismiss="false" display="true" rounded="true">
        An error occurred on your request.
    </v-alert>
    
    <div>
        {{ $content }}
    </div>

    {{-- This is a comment --}}
</body>
</html>