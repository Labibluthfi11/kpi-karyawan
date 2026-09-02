<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Penilaian KPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Penilaian untuk {{ $user->name }}</h1>
        <form action="{{ route('kpi.store', $user) }}" method="POST">
            @csrf
            @foreach($questions as $question)
                <div class="mb-4">
                    <label class="block mb-1">{{ $question->question_text }} ({{ $question->category }})</label>
                    <select name="scores[{{ $question->id }}]" class="w-full border p-2 rounded" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            @endforeach
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Simpan Penilaian</button>
        </form>
    </div>
</body>
</html>
