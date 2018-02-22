<?php

namespace Vadiasov\ArtistsAdmin\Controllers;

use App\Artist;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vadiasov\ArtistsAdmin\Requests\ImageRequest;
use Vadiasov\ArtistsAdmin\Requests\ArtistRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class ArtistsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $active  = 'artists';
        $user    = Auth::user();
        $artists = Artist::all();
        $genres  = Genre::all()->keyBy('id');
        
        return view('artists-admin::admin.artists.index', compact(
            'active',
            'user',
            'artists',
            'genres'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $active = 'artists';
        $user   = Auth::user();
        $genres = Genre::all()->keyBy('id');
        $tags   = Tag::all()->keyBy('id');
        
        return view('artists-admin::admin.artists.create', compact(
            'active',
            'user',
            'genres',
            'tags'
        ));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Vadiasov\ArtistsAdmin\Requests\ArtistRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ArtistRequest $request)
    {
        $array       = [];
        $array['fb'] = $request->facebook;
        $array['li'] = $request->linkedin;
        $array['in'] = $request->instagram;
        $array['go'] = $request->google;
        
        $artist = new Artist([
            'name'         => $request->name,
            'url'          => $request->url,
            'location'     => $request->location,
            'genre_id'     => $request->genre_id,
            'tags'         => json_encode($request->tags),
            'bio'          => $request->editor1,
            'websites'     => $request->websites,
            'social_links' => json_encode($array),
            'email'        => $request->email,
        ]);
        
        $artist->save();
        
        return redirect(route('admin/artists'))->with('status', 'New Artist has been created!');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $active       = 'artists';
        $user         = Auth::user();
        $artist       = Artist::whereId($id)->first();
        $tagsSelected = json_decode($artist->tags);
        $socialLinks  = json_decode($artist->social_links);
        $genres       = Genre::all()->keyBy('id');
        $tags         = Tag::all()->keyBy('id');
        
        $arrayJs = '[' . implode(",", $tagsSelected) . ']';
        
        return view('artists-admin::admin.artists.edit', compact(
            'active',
            'user',
            'artist',
            'arrayJs',
            'socialLinks',
            'genres',
            'tags'
        ));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param \Vadiasov\ArtistsAdmin\Requests\ArtistRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ArtistRequest $request, $id)
    {
        $artist = Artist::whereId($id)->first();
        
        $array       = [];
        $array['fb'] = $request->facebook;
        $array['li'] = $request->linkedin;
        $array['in'] = $request->instagram;
        $array['go'] = $request->google;
        
        $artist->name         = $request->name;
        $artist->url          = $request->url;
        $artist->location     = $request->location;
        $artist->genre_id     = $request->genre_id;
        $artist->tags         = json_encode($request->tags);
        $artist->bio          = $request->editor1;
        $artist->websites     = $request->websites;
        $artist->social_links = json_encode($array);
        $artist->email        = $request->email;
        
        $artist->save();
        
        return redirect(route('admin/artists'))->with('status', 'The Artist has been edited!');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $artist = Artist::whereId($id);
        
        $artist->delete();
        
        return redirect(route('admin/artists'))->with('status', 'The Artist has been deleted!');
    }
    
    public function editImage($id)
    {
        $active = 'artists';
        $user   = Auth::user();
        $artist = Artist::whereId($id)->first();
        
        return view('artists-admin::admin.artists.edit_image', compact(
            'active',
            'user',
            'artist'
        ));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param \Vadiasov\ArtistsAdmin\Requests\ImageRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     */
    public function storeImage(ImageRequest $request, $id)
    {
        // first save file on disk
        $file = $request->photo;
//        dd($file);
        
        $size = getimagesize($file);
        
        $fileName = 'temp-' . date('Y-m-d_h-i-s') . ('.') . $request->photo->extension();
        $path     = $request->photo->storeAs('public/temp', $fileName);
        
        // second save
        $artist                  = Artist::whereId($id)->first();
        $artist->profile_picture = $fileName;
        $artist->save();
        
        return redirect(route('edit-image', $id))->with('status', 'Upload successful!');
    }
    
    public function cropImage($id)
    {
        $active = 'artists';
        $user   = Auth::user();
        $artist = Artist::whereId($id)->first();
        
        return view('artists-admin::admin.artists.crop_image', compact(
            'active',
            'user',
            'artist'
        ));
    }
    
    public function processImage($id)
    {
        $quality = 90;
        $artist = Artist::whereId($id)->first();
        $path = storage_path('app/public/temp/' . $artist->profile_picture);
//        $pathOut = storage_path('app/public/images/' . $artist->profile_picture);
//        $src  = File::get($path);
        print_r(Input::get('h'));
        print_r(Input::get('x'));
//        dd
        $img  = imagecreatefromjpeg($path);
        $dest = ImageCreateTrueColor(Input::get('w'),
            Input::get('h'));
        imagecopyresampled($dest, $img, 0, 0, Input::get('x'),
            Input::get('y'), Input::get('w'), Input::get('h'),
            Input::get('w'), Input::get('h'));
        imagejpeg($dest, $path, $quality);
    
        return "<img src='" . asset('Storage/images/' . $artist->profile_picture) . "'>";
    }
}
