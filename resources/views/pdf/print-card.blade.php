<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 40px;
            position: absolute;
            width: 100%;
        }

        .student-photo {
            width: 80px;
            height: 80px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
            z-index: 99;
            top: 140;
            left: 20;
        }

        .student-info {
            position: relative;
            z-index: 88;
            top: 110;
            left: 150;
        }

        .student-qrcode {
            position: relative;
            z-index: 88;
            top: 105;
            left: 200;
        }

        .student-info p {
            font-size: 10px;
            color: white;
            font-family: Arial, Helvetica, sans-serif;
        }

        .card-image {
            width: 320px;
            height: 200px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 8px;
        }
    </style>
</head>

<body>
    @if (isset($card_id) && $card_id)
        <div class="card-container">
            @if (isset($student->photo))
                <div class="student-photo"
                    style="background-image: url('{{ public_path('storage/' . $student->photo) }}');">
                </div>
            @endif

            <div class="student-info">
                <p style="margin-bottom: 10px">{{ $student->full_name ?? '-' }}</p>
                <p>{{ $student->nis ?? '-' }}</p>
                <p style="margin-top: 5px">{{ $student->class_room->name_class ?? '-' }}</p>
            </div>

            <div class="student-qrcode">
                {!! DNS2D::getBarcodeHTML("$student->nis", 'QRCODE', 2, 2) !!}
            </div>

            <img src="{{ public_path('static/ryoogen/illustration/card-identity.png') }}" alt=""
                class="card-image">
            <img src="{{ public_path('static/ryoogen/illustration/card-identity2.png') }}" alt=""
                class="card-image">
        </div>
    @else
        @if (count($student) >= 1)
            @foreach ($student as $data)
                <div class="card-container">
                    @if (isset($data->photo))
                        <div class="student-photo"
                            style="background-image: url('{{ public_path('storage/' . $data->photo) }}');">
                        </div>
                    @endif

                    <div class="student-info">
                        <p style="margin-bottom: 10px">{{ $data->full_name ?? '-' }}</p>
                        <p>{{ $data->nis ?? '-' }}</p>
                        <p style="margin-top: 5px">{{ $data->class_room->name_class ?? '-' }}</p>
                    </div>

                    <div class="student-qrcode">
                        {!! DNS2D::getBarcodeHTML("$data->nis", 'QRCODE', 2, 2) !!}
                    </div>

                    <img src="{{ public_path('static/ryoogen/illustration/card-identity.png') }}" alt=""
                        class="card-image">
                    <img src="{{ public_path('static/ryoogen/illustration/card-identity2.png') }}" alt=""
                        class="card-image">
                </div>
            @endforeach
        @endif
    @endif
</body>

</html>
