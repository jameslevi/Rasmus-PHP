<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emit['title'] }}</title>
</head>
<body class="v-family-sans v-bgcolor-#dddddd">

    <v-box marginbottom="10" height="200px" title="$emit['title']">
        This is a sample box.
    </v-box>

    <v-box id="main_box" padding="20" marginbottom="10">

    {{-- This is a sample alert --}}

    <v-alert id="alert_1" scheme="success" variant="default" size="13" display="true" rounded="true">
        Credentials successfully saved.
    </v-alert>

    <v-line weight="5" color="success" rounded="true"></v-line>

    <v-alert id="alert_2" scheme="error" variant="border" dismiss="true" display="true" rounded="true">
        <b>An error occurred on your request.</b>
    </v-alert>

    <v-line></v-line>

    <v-alert id="alert_3" scheme="info" variant="outline" size="14" display="true" rounded="true">
        <b>An error occurred on your request.</b>
    </v-alert>
    
    <div>
        {{ $content }}
    </div>

    <v-button id="button1" name="submit" bold="true" size="small" scheme="primary" rounded="true">Submit</v-button>

    <v-line></v-line>

    <v-button scheme="success" size="large" width="100" rounded="true">Reset</v-button>

    {{-- This is a comment --}}

    </v-box>
    <v-box>
        
    </v-box>

</body>
</html>