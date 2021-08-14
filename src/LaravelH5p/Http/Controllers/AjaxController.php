<?php

namespace Zaki\LaravelH5p\Http\Controllers;

use App\Http\Controllers\Controller;
use Zaki\LaravelH5p\Events\H5pEvent;
use H5PEditorEndpoints;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Log;
use Zaki\LaravelH5p\Eloquents\H5pLibrary;
use Zaki\LaravelH5p\Eloquents\H5pResult;
use Zaki\LaravelH5p\Eloquents\H5pContentsUserData;
use Zaki\LaravelH5p\Eloquents\H5pTmpfile;

class AjaxController extends Controller
{
    public function libraries(Request $request)
    {
        $machineName   = $request->get('machineName');
        $major_version = $request->get('majorVersion');
        $minor_version = $request->get('minorVersion');

        $h5p    = App::make('LaravelH5p');
        $core   = $h5p::$core;
        $editor = $h5p::$h5peditor;

        //log($machineName);
        Log::debug('An informational message.' . $machineName . '=====' . $h5p->get_language());
        if ($machineName) {
            $defaultLanguag = $editor->getLibraryLanguage($machineName, $major_version, $minor_version, $h5p->get_language());
            Log::debug('An informational message.' . $machineName . '=====' . $h5p->get_language() . '=====' . $defaultLanguag);

            //   public function getLibraryData($machineName, $majorVersion, $minorVersion, $languageCode, $prefix = '', $fileDir = '', $defaultLanguage) {

            $editor->ajax->action(H5PEditorEndpoints::SINGLE_LIBRARY, $machineName, $major_version, $minor_version, $h5p->get_language(), '', $h5p->get_h5plibrary_url('', true), $defaultLanguag);  //$defaultLanguage
            // Log library load
            event(new H5pEvent('library', null, null, null, $machineName, $major_version . '.' . $minor_version));
        } else {
            // Otherwise retrieve all libraries
            $editor->ajax->action(H5PEditorEndpoints::LIBRARIES);
        }
    }

    public function singleLibrary(Request $request)
    {
        $h5p    = App::make('LaravelH5p');
        $editor = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::SINGLE_LIBRARY, $request->get('_token'));
    }

    public function contentTypeCache(Request $request)
    {
        $h5p    = App::make('LaravelH5p');
        $editor = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::CONTENT_TYPE_CACHE, $request->get('_token'));
    }

    public function libraryInstall(Request $request)
    {
        $h5p    = App::make('LaravelH5p');
        $editor = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::LIBRARY_INSTALL, $request->get('_token'), $request->get('id'));
    }

    public function libraryUpload(Request $request, $nonce = null)
    {
        $filePath = $request->file('h5p')->getPathName();
        $h5p      = App::make('LaravelH5p');
        $core     = $h5p::$core;
        if (isset($nonce)) {
            $core->fs->setNonce($nonce);
        }
        $editor = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::LIBRARY_UPLOAD, $request->get('_token'), $filePath, $request->get('contentId'));
    }

    public function libraryFilter(Request $request, $nonce = null)
    {
        $h5p    = App::make('LaravelH5p');
        $editor = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::FILTER, $request->get('_token'), $request->get('libraryParameters'));
    }

    public function files(Request $request, $nonce = null)
    {
        $filePath = $request->file('file');
        $h5p      = App::make('LaravelH5p');
        $editor   = $h5p::$h5peditor;
        $editor->ajax->action(H5PEditorEndpoints::FILES, $request->get('_token'), $request->get('contentId'));

        if ($nonce) {
            $last = H5pTmpfile::orderBy('id', 'desc')->first();
            $last->update(['nonce' => $nonce]);
        }
    }

    public function __invoke(Request $request)
    {
        return response()->json($request->all());
    }

    public function finish(Request $request)
    {
        $input = $request->all();

        $data = [
            'content_id' => $input['contentId'],
            'max_score'  => $input['maxScore'],
            'score'      => $input['score'],
            'opened'     => $input['opened'],
            'finished'   => $input['finished'],
            'time'       => $input['finished'] - $input['opened'],
            'user_id'    => \Auth::user()->id,
        ];

        H5pResult::create($data);

        return response()->json([
                                    'success' => true,
                                ]);
    }

    public function contentUserData(Request $request)
    {
        $input = $request->all();

        $contentId = basename($request->header('referer'));

        $userData = H5pContentsUserData::where([
                                                   'content_id'     => $contentId,
                                                   'data_id'        => 'state',
                                                   'sub_content_id' => 0,
                                                   'user_id'        => \Auth::user()->id,
                                               ])->first();

        $data = [
            'content_id'     => $contentId,
            'data_id'        => 'state',
            'sub_content_id' => 0,
            'user_id'        => \Auth::user()->id,
            'data'           => $input['data'],
            'preload'        => $input['preload'],
            'invalidate'     => $input['invalidate'],
            'updated_at'     => now(),
        ];

        if (empty($userData)) {
            H5pContentsUserData::create($data);
        } else {
            $userData->update($data);
        }

        return response()->json([
                                    'success' => true,
                                ]);
    }
}
