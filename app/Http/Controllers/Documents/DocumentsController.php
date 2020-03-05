<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documents;
use Auth;
use DB;
use File;
use Storage;
use Carbon\Carbon;

class DocumentsController extends Controller
{

    public function codeNumber()
    {
        $number = mt_rand(1000000000, mt_getrandmax());
        if (count($this->codeNumberExist($number))) {
            return $this->codeNumber();
        }
        return $number;
    }
    public function codeNumberExist($number)
    {
        return Documents::where('u_id', $number)->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('documents.index');
    }

    public function documents_upload(Request $request)
    {

        $path = '';
        $file = null;
        $date_uploaded = Carbon::now()->format('Y-m');
        try {
            DB::beginTransaction();

            $file = $request->file('files');
            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());
            $documents = new Documents([
                'u_id'      => $this->codeNumber(),
                'name'      => $file->getClientOriginalName(),
                'note'      => $request->note,
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'    => 'attachment',
                'version'   => '1.0',
                'is_current'=> '1',
            ]);

            $path = $file->store('public/documents/' . $date_uploaded . '/' . $documents->u_id . '/');

            // associated user
            $documents->user()->associate(\Auth::user());
            // $documents->agent()->associate($agent);
            $documents->save();
            // $documents->path_id = $agent->id;
            $documents->update();
            $attID = $documents->id;

            DB::commit();

            $file_path = '/storage/documents/'. $date_uploaded . '/' . $documents->u_id . '/' . $documents->hash_name . '.' . $documents->ext;

            $file = [
                'id' => $documents->id,
                'lastModified' => $documents->updated_at->timestamp,
                'lastModifiedDate' => $documents->updated_at,
                'name' => $documents->name,
                'size' => $documents->size,
                'file_path' => $file_path,
                'file_ext' => $documents->ext,
                'file_type' => explode('/', $documents->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }


        return $request->all();
    }

    public function documents_fetch()
    {
        $documentsUploaded = Documents::groupBy('u_id')->where('is_current', 1)->get();

        // dd($agentAttachments->toArray());

        $documents = [];
        foreach ($documentsUploaded as $key => $value) {

            // dd($value->updated_at->timestamp);
            $file_path = '/storage/documents/' . $value->created_at->format('Y-m') . '/' . $value->u_id . '/' . $value->hash_name . '.' . $value->ext;

            array_push($documents, [
                'id' => $value->id,
                'u_id' => $value->u_id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
                'version' => $value->version,
            ]);
        }

        return $documents;
    }

    public function documents_delete($id)
    {
        $documentsUploaded = Documents::find($id);
        $documentsGrouped = Documents::where('u_id', $documentsUploaded->u_id)->get();
        $path = '/public/documents/' . $documentsUploaded->created_at->format('Y-m') . '/' . $documentsUploaded->u_id . '/' . $documentsUploaded->hash_name . '.' . $documentsUploaded->ext;
        if ($documentsUploaded->is_current == 1) {
            try {
                DB::beginTransaction();
                $documentsUploaded->delete();
                // remove file
                $isDeleted = Storage::disk('local')->delete($path);
                if (!$isDeleted) throw new \Exception("File not deleted.");
                DB::commit();
                if($documentsGrouped->count() > 1){
                    $getLatestDocuments = Documents::where('u_id', $documentsUploaded->u_id)->orderBy('version', 'desc')->first();
                    $getLatestDocuments->is_current = 1;
                    $getLatestDocuments->update();
                }
                return ['status' => 'success'];
            } catch (\Exception $e) {
                DB::rollBack();
                
                // remove file
                return $e->getMessage();
            }
        } else {
            try {
                DB::beginTransaction();
                $documentsUploaded->delete();
                // remove file
                $isDeleted = Storage::disk('local')->delete($path);
                if (!$isDeleted) throw new \Exception("File not deleted.");
                DB::commit();
                return ['status' => 'success'];
            } catch (\Exception $e) {
                DB::rollBack();
                // remove file
                return $e->getMessage();
            }
        }


    }

    public function documents_preview($id)
    {
        // file model instance
        $file = Documents::find($id);

        $path = storage_path() . '/app/public/documents/' . $file->created_at->format('Y-m') . '/' . $file->u_id . '/' . $file->hash_name . '.' . $file->ext;

        // raw file contents
        $fileContent = File::get($path);

        return response($fileContent)->header('Content-Type', $file->mime_type);
    }

    public function documents_update($uid) {
        $findDocuments = Documents::where('u_id', $uid)->first();
        $findRelatedDocuments = Documents::where('u_id', $uid)->select(['id', 'note', 'is_current'])->get();

        \JavaScript::put([
            'related_documents' => $findDocuments,
            'find_related_documents' => $findRelatedDocuments,
        ]);
        return view('documents.edit');
    }

    public function documents_related_upload(Request $request)
    {

        $path = '';
        $file = null;
        $date_uploaded = Carbon::now()->format('Y-m');

        $getRelatedDocuments = documents::where('u_id', $request->u_id)->get();

        foreach ($getRelatedDocuments as $key => $value) {
            if ($value->is_current == 1) {
                $value->is_current = 0;
                $value->update();
            }
            $ver = explode('.', $value->version);
            if ($ver[1] < 9) {
                $ver[1] = $ver[1] + 1;
            } else {
                $ver[0] = $ver[0] + 1;
                $ver[1] = 1;
            }
            $new_version = implode('.', $ver);
        }

        try {
            DB::beginTransaction();

            $file = $request->file('files');

            $hashFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file->hashName());

            $documents = new Documents([
                'u_id'      => $request->u_id,
                'name'      => $file->getClientOriginalName(),
                'note'      => $request->note,
                'hash_name' => $hashFileName,
                'size'      => $file->getClientSize(),
                'mime_type' => $file->getMimeType(),
                'ext'       => $file->guessClientExtension(),
                '_input'    => 'attachment',
                'version'   => $new_version,
                'is_current' => '1',
            ]);

            $path = $file->store('public/documents/' . $date_uploaded . '/' . $documents->u_id . '/');

            // associated user
            $documents->user()->associate(\Auth::user());
            // $documents->agent()->associate($agent);
            $documents->save();
            // $documents->path_id = $agent->id;
            $documents->update();
            $attID = $documents->id;

            DB::commit();

            $file_path = '/storage/documents/' . $date_uploaded . '/' . $documents->u_id . '/' . $documents->hash_name . '.' . $documents->ext;

            $file = [
                'id' => $documents->id,
                'lastModified' => $documents->updated_at->timestamp,
                'lastModifiedDate' => $documents->updated_at,
                'name' => $documents->name,
                'size' => $documents->size,
                'file_path' => $file_path,
                'file_ext' => $documents->ext,
                'file_type' => explode('/', $documents->mime_type)[0],
            ];

            // return response(['status' => 'success', 'attID' => $attID, 'preview' => $preview], 200)->header('Content-Type', 'text/json');
            return response(['status' => 'success', 'file' => $file], 200)->header('Content-Type', 'text/json');
            // return response(['status' => 'success', 'attID' => 0], 200)->header('Content-Type', 'text/json');
        } catch (\Exception $e) {
            DB::rollBack();

            // remove file
            Storage::delete($path);
            dd($e->getMessage());
        }


        return $request->all();
    }

    public function documents_related_fetch($uid)
    {
        $documentsUploaded = Documents::where('u_id', $uid)->get();
        
        $documents = [];
        foreach ($documentsUploaded as $key => $value) {
            // dd($value->updated_at->timestamp);
            $file_path = '/storage/documents/' . $value->created_at->format('Y-m') . '/' . $value->u_id . '/' . $value->hash_name . '.' . $value->ext;

            array_push($documents, [
                'id' => $value->id,
                'u_id' => $value->u_id,
                'lastModified' => $value->updated_at->timestamp,
                'lastModifiedDate' => $value->updated_at,
                'name' => $value->name,
                'size' => $value->size,
                'file_path' => $file_path,
                'file_ext' => $value->ext,
                'file_type' => explode('/', $value->mime_type)[0],
                'version' => $value->version,
                'note' => $value->note,
                'is_current' => $value->is_current,
            ]);
        }

        return $documents;
    }

    public function documents_note_update(Request $request, $id) {
        
        $updateNote = documents::select(['id', 'note', 'is_current', 'u_id'])->find($id);

        if($request->is_current == true) {
            $updateIsCurrent = documents::where('u_id', $updateNote->u_id)->get();
            
            foreach ($updateIsCurrent as $key => $value) {
                if($value->is_current == 1) {
                    $value->is_current = 0;
                    $value->update();
                }
            }
        }
        
        
        $updateNote->note = $request->note;
        $updateNote->is_current = $request->is_current == true ? 1 : $updateNote->is_current;
        $updateNote->update();
    }

}
