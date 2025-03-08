<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .content {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 5px;
        }
        .title {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }
        .body {
            margin-bottom: 30px;
        }
        .image-container {
            text-align: center;
            margin: 20px 0;
        }
        .image {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white !important;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px 0;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if(isset($additional_data['company_logo']))
                <img src="{{ $additional_data['company_logo'] }}" alt="Logo" style="max-height: 60px;">
            @endif
        </div>
        
        <div class="content">
            <h1 class="title">{{ $title }}</h1>
            
            <div class="body">
                {!! nl2br(e($body)) !!}
            </div>
            
            @if(isset($image))
                <div class="image-container">
                    <img src="{{ $image }}" alt="Notification Image" class="image">
                </div>
            @endif
            
            @if(isset($button))
                <div style="text-align: center; margin-top: 30px;">
                    <a href="{{ $button['url'] }}" class="button">{{ $button['text'] }}</a>
                </div>
            @endif
        </div>
        
        <div class="footer">
            @if(isset($additional_data['company_name']))
                <p>&copy; {{ date('Y') }} {{ $additional_data['company_name'] }}. All rights reserved.</p>
            @endif
            
            @if(isset($additional_data['company_email']) || isset($additional_data['company_phone']))
                <p>
                    @if(isset($additional_data['company_email']))
                        Email: {{ $additional_data['company_email'] }}
                    @endif
                    
                    @if(isset($additional_data['company_email']) && isset($additional_data['company_phone']))
                        |
                    @endif
                    
                    @if(isset($additional_data['company_phone']))
                        Phone: {{ $additional_data['company_phone'] }}
                    @endif
                </p>
            @endif
        </div>
    </div>
</body>
</html>