<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .today {
            background-color: #ffeb3b;
        }
    </style>
</head>
<body>
    <h1>Calendar</h1>

    <!-- Form to Add Events -->
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Event Title" required>
        <input type="date" name="date" required>
        <textarea name="description" placeholder="Event Description"></textarea>
        <button type="submit">Add Event</button>
    </form>

    <!-- Display Events -->
    <h2>Events</h2>
    <ul>
        @foreach($events as $event)
            <li>{{ $event->title }} - {{ $event->date }}</li>
        @endforeach
    </ul>

    <!-- Display Calendar -->
    <h2>Calendar</h2>
    <table>
        <tr>
            <th>Sun</th>
            <th>Mon</th>
            <th>Tue</th>
            <th>Wed</th>
            <th>Thu</th>
            <th>Fri</th>
            <th>Sat</th>
        </tr>
        @php
            $date = \Carbon\Carbon::now()->startOfMonth();
            $startDayOfWeek = $date->dayOfWeek;
            $daysInMonth = $date->daysInMonth;
            $today = \Carbon\Carbon::today();
        @endphp

        <tr>
            @for ($i = 0; $i < $startDayOfWeek; $i++)
                <td></td>
            @endfor

            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php
                    $currentDate = $date->copy()->day($day);
                @endphp
                <td class="{{ $currentDate->isToday() ? 'today' : '' }}">
                    {{ $day }}
                    <ul>
                        @foreach ($events as $event)
                            @if ($event->date == $currentDate->toDateString())
                                <li>{{ $event->title }}</li>
                            @endif
                        @endforeach
                    </ul>
                </td>

                @if (($day + $startDayOfWeek) % 7 == 0)
                    </tr><tr>
                @endif
            @endfor

            @for ($i = ($startDayOfWeek + $daysInMonth) % 7; $i < 7 && $i != 0; $i++)
                <td></td>
            @endfor
        </tr>
    </table>
</body>
</html>
