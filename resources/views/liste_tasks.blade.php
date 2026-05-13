<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes tâches</title>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #F7F6F3;
            --surface: #FFFFFF;
            --border: #E8E5DF;
            --text: #1A1916;
            --muted: #9B9690;
            --accent: #273bb1;
            --accent-light: #E8F2EB;
            --danger: #C0392B;
            --danger-light: #FAEAE8;
            --radius: 12px;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            padding: 40px 20px;
        }

        .app {
            max-width: 560px;
            margin: 0 auto;
        }

        /* En-tête */
        .header {
            margin-bottom: 32px;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 500;
            color: var(--text);
            letter-spacing: -0.5px;
        }

        .count-badge {
            font-size: 11px;
            font-family: 'DM Mono', monospace;
            background: var(--accent-light);
            color: var(--accent);
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
            vertical-align: middle;
        }

        /* Formulaire */
        .form-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px;
            display: flex;
            gap: 10px;
            margin-bottom: 24px;
        }

        .form-card input {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            outline: none;
        }

        .form-card input:focus {
            border-color: var(--accent);
        }

        .btn-add {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        /* Liste */
        .section-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--muted);
            letter-spacing: .08em;
            text-transform: uppercase;
            font-family: 'DM Mono', monospace;
            margin-bottom: 10px;
        }

        .task-list {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .task-item {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .task-item.done {
            background: #FAFAF8;
            opacity: .75;
        }

        .task-title {
            flex: 1;
            font-size: 14px;
            color: var(--text);
        }

        .task-title.done {
            text-decoration: line-through;
            color: var(--muted);
        }

        .task-actions {
            display: flex;
            gap: 6px;
        }

        /* Boutons */
        .btn-toggle {
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }

        .btn-toggle:hover {
            background: var(--accent-light);
            color: var(--accent);
            border-color: var(--accent);
        }

        .btn-delete {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
        }

        .btn-delete:hover {
            background: var(--danger-light);
            color: var(--danger);
        }
    </style>
</head>

<body>
    <div class="app">

        <div class="header">
            <h1>
                Mes tâches
                <span class="count-badge">
                    {{ $tasks->where('is_completed', false)->count() }} restantes
                </span>
            </h1>
        </div>

        {{-- Formulaire --}}
        <div class="form-card">
            <form action="/exercices" method="POST" style="display:flex;gap:10px;flex:1">
                @csrf
                <input type="text" name="title" placeholder="Ajouter une nouvelle tâche..." required>
                <button type="submit" class="btn-add">Ajouter</button>
            </form>
        </div>

        <p class="section-label">Tâches</p>

        <div class="task-list">
            @forelse ($tasks as $task)

                <div class="task-item {{ $task->is_completed ? 'done' : '' }}">

                    {{-- Titre --}}
                    <span class="task-title {{ $task->is_completed ? 'done' : '' }}">
                        {{ $task->title }}
                    </span>

                    <div class="task-actions">

                        {{-- Bouton toggle --}}
                        <form action="/exercices/{{ $task->id }}/toggle" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-toggle">
                                {{ $task->is_completed ? 'Rouvrir' : 'Terminer' }}
                            </button>
                        </form>

                        {{-- Bouton supprimer --}}
                        <form action="/exercices/{{ $task->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">✕</button>
                        </form>

                    </div>
                </div>

            @empty
                <p style="text-align:center;color:var(--muted);padding:40px">
                    Aucune tâche — ajoutez-en une !
                </p>
            @endforelse
        </div>

    </div>
</body>

</html>