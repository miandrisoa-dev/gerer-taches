<?php

namespace App\Http\Controllers;//↑ dit à Laravel où se trouve ce fichier

use App\Models\Task;// on importe le modèle Task
use Illuminate\Http\Request;//↑ on importe Request pour lire le formulaire


class TaskController extends Controller
{
    // MÉTHODE 1 : afficher la liste
    public function index()
    {
        $tasks = Task::all(); // récupère tout depuis la BDD
        return view('liste_tasks', ['tasks' => $tasks]);
    }

    // MÉTHODE 2 : enregistrer une tâche
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',
        ]);

        $task = new Task();
        $task->title = $request->input('title');
        $task->save();
        return redirect('/exercices');
    }

    // MÉTHODE 3 : delete une tâche
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/exercices');
    }

    //Nouvelle methode 
    public function toggle(Task $task)
    {
        // ! = l'opérateur "inverse" en PHP
        // Si is_completed était false → devient true
        // Si is_completed était true  → devient false
        $task->is_completed = !$task->is_completed;

        $task->save(); // sauvegarde en BDD

        return redirect('/exercices');
    }
}