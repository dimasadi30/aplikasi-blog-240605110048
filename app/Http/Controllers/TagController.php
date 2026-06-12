<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $tags = Tag::withCount('artikel')
            ->orderBy('nama_tag', 'asc')
            ->paginate(10);
        return view('tag.index', compact('tags'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('tag.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_tag' => 'required|string|max:100|unique:tags,nama_tag',
        ]);

        try {
            Tag::create([
                'nama_tag' => $request->nama_tag,
                'slug' => Str::slug($request->nama_tag),
            ]);

            return redirect()->route('tags.index')->with('sukses', 'Tag berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('gagal', 'Gagal menambahkan tag: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $tag = Tag::findOrFail($id);
        return view('tag.edit', compact('tag'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $tag = Tag::findOrFail($id);

        $request->validate([
            'nama_tag' => 'required|string|max:100|unique:tags,nama_tag,' . $id,
        ]);

        try {
            $tag->update([
                'nama_tag' => $request->nama_tag,
                'slug' => Str::slug($request->nama_tag),
            ]);

            return redirect()->route('tags.index')->with('sukses', 'Tag berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('gagal', 'Gagal memperbarui tag: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $tag = Tag::findOrFail($id);
        $tag->delete();
        return redirect()->route('tags.index')->with('sukses', 'Tag berhasil dihapus.');
    }

    public function merge(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'source_tag_id' => 'required|exists:tags,id',
            'target_tag_id' => 'required|exists:tags,id|different:source_tag_id',
        ]);

        $sourceTag = Tag::findOrFail($request->source_tag_id);
        $targetTag = Tag::findOrFail($request->target_tag_id);

        // Move all artikel-tag relationships from source to target safely
        $sourceTag->artikel()->each(function ($artikel) use ($targetTag) {
            $artikel->tags()->syncWithoutDetaching([$targetTag->id]);
        });

        // Detach all articles from source tag
        $sourceTag->artikel()->detach();

        // Delete source tag
        $sourceTag->delete();

        return redirect()->route('tags.index')
            ->with('sukses', 'Tag berhasil digabungkan.');
    }
}
