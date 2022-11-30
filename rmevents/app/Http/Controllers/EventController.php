<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

use App\Models\User;

class EventController extends Controller
{
    public function index()
    {

        $search = request('search');

        if ($search) {
            $events = Event::where([['title', 'like', '%' . $search . '%']])->get(); //lógica para a busca
        } else {
            $events = Event::all(); //traz os dados do banco de dados
        }


        return view('welcome', ['events' => $events, 'search' => $search]);
    }

    public function contact()
    {
        return view('contact');
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items;

        //image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) { //verificando se é uma imagem e se tem arquivo

            $requestImage = $request->image;

            $extension = $requestImage->extension(); //pegando extensão do arquivo

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension; //pegando nome do arquivo + tempo real + a extensão do arquivo 

            $requestImage->move(public_path('img/events'), $imageName); //adicionando o arquivo ao servidor

            $event->image = $imageName;
        }

        $user = auth()->user();
        $event->user_id = $user->id;

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id)
    {
        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray(); //pegando o usuaria do banco, informando que é o primeiro que achar e transformando os dados em array

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner]);
    }

    public function dashboard()
    {
        $user = auth()->user();

        $events = $user->events;

        return view('events.dashboard', ['events' => $events]);
    }

    public function destroy($id)
    { //criando regra de deletar evento
        Event::findOrFail($id)->delete(); //achando o id do evento para deleter

        return redirect('/dashboard')->with('msg', 'Evento Excluído com sucesso!'); //mensagem de sucesso
    }

    public function edit($id)
    {

        $event = Event::findOrFail($id); //lógica para editar

        return view('events.edit', ['event' => $event]);
    }

    public function update(Request $request) //lógica para atualizar os dados
    {

        $data = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) { //verificando se é uma imagem e se tem arquivo

            $requestImage = $request->image;

            $extension = $requestImage->extension(); //pegando extensão do arquivo

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension; //pegando nome do arquivo + tempo real + a extensão do arquivo 

            $requestImage->move(public_path('img/events'), $imageName); //adicionando o arquivo ao servidor

            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data); //lógica para o update da dados

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!'); //mensagem de sucesso
    }

    public function joinEvent($id){

        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/dashboard')->with('msg', 'Sua presença está confirmada no evento '.$event->title);
    }
}
