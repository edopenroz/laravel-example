<?php
 
use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home'); 
});

// JOBS INDEX
Route::get('/jobs', function () {
    $jobs = Job::with('employer')->latest()->cursorPaginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});

// JOBS CREATE
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// JOBS SHOW
Route::get('/jobs/{id}', function ($id) {

    $job = Job::find($id);

    return view('jobs.show', [ 'job' => $job ]);
});

// JOBS STORE
Route::post('/jobs', function () {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1
    ]);

    return redirect('/jobs');
});

// JOBS EDIT
Route::get('/jobs/{id}/edit', function ($id) {

    $job = Job::find($id);

    return view('jobs.edit', [ 'job' => $job ]);
});

// JOBS UPDATE
Route::patch('/jobs/{id}', function ($id) {
    request()->validate([
        'title' => ['required', 'min:3'],
        'salary' => ['required']
    ]);

    // authorize (on hold...)

    $job = Job::findOrFail($id);

    $job->update([
        'title' => request('title'),
        'salary' => request('salary')
    ]);

    return redirect('/jobs/' . $job->id);
});

// JOBS DESTROY
Route::delete('/jobs/{id}', function ($id) {
    // authorize (on hold...)

    $job = Job::findOrFail($id);
    $job->delete();

    return redirect('/jobs');
});



Route::get('/contact', function () {
    return view('contact');
});

