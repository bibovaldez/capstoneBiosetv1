<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ImageCaptureController extends Controller
{
    protected $imageRecognitionController;
    protected $encryptionController;
    protected $decryptionController;

    public function __construct(ImageRecognitionController $imageRecognitionController, EncryptionController $encryptionController, DecryptionController $decryptionController)
    {
        $this->imageRecognitionController = $imageRecognitionController;
        $this->encryptionController = $encryptionController;
        $this->decryptionController = $decryptionController;
    }

    public function upload(Request $request)
    {
        // return response()->json(200);
        //validate image
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // try {
        $uploadedFile = $request->file('image');
        $imageData = file_get_contents($uploadedFile->getRealPath());


        // Encrypt the image data
        $encryptedImage = $this->encryptionController->encryptData($imageData);

        // Process the image and get the recognition result
        $recognitionResult = $this->imageRecognitionController->processImage($uploadedFile);

        // Encrypt the recognition result
        $encryptedResult = $this->encryptionController->encryptData(json_encode($recognitionResult));

        // Decrypt the image and result for verification
        $decryptedImage = $this->decryptionController->decryptData($encryptedImage);
        $decryptedResult = $this->decryptionController->decryptData($encryptedResult);


        // Debug output
        dd([
            // 'original_image' => base64_encode($imageData),
            // 'encrypted_image' => $encryptedImage,
            // 'decrypted_image' => base64_encode($decryptedImage),
            'original_result' => $recognitionResult,
            'encrypted_result' => $encryptedResult,
            'decrypted_result' => json_decode($decryptedResult, true)
        ]);
















        // // Check if predictions were made
        // if (empty($recognitionResult['predictions'])) {
        //     return response()->json(['message' => 'No chicken detected'], 200);
        // }else{
        //     // show how many chickens were detected
        //     $detected = $recognitionResult['predictions'];
        //     $count = count($detected);

        //     dd($detected, $count);
        //     return response()->json(['message' => $count . ' chicken(s) detected'], 200);
        // }

        // $encryptedRecognitionResult = $this->encryptionController->encryptData(json_encode($recognitionResult));



        // $this->storeImage($compressedEncryptedImage, $encryptedRecognitionResult);

        // return response()->json(['message' => 'Image uploaded and processed successfully'], 201);
        // // } catch (ValidationException $e) {
        // //     dd($e->validator->errors());
        // //     return response()->json(['errors' => $e->errors()], 422);
        // // } catch (\Exception $e) {
        // //     dd(''. $e->getMessage());
        // //     Log::error('Image upload failed: ' . $e->getMessage());
        // //     return response()->json(['error' => 'Image upload failed'], 500);
        // // }
    }
    // protected function storeImage(string $compressedEncryptedImage, string $encryptedRecognitionResult)
    // {
    //     $image = new Image();
    //     $image->encrypted_image = $compressedEncryptedImage;
    //     $image->user_id = Auth::id();
    //     $image->building_id = Auth::user()->building_id;
    //     $image->recognition_result_encrypted = $encryptedRecognitionResult;
    //     $image->save();
    // }

}
