<?php

namespace App\Http\Controllers;

use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChildController extends Controller {

    // Field Names and Validation Rules

    private $fieldNames = [
        "child_first_name",
        "child_middle_name",
        "child_last_name",
        "child_age",
        "child_gender",
        "child_different_address",
        "child_address",
        "child_city",
        "child_state",
        "child_country",
        "child_zip_code"
    ];

    private $validationRules = [
        "child_first_name.*" =>  array("required", "regex:/^[a-zA-Z\s]+$/"),
        "child_middle_name.*" =>  array("required", "regex:/^[a-zA-Z\s]+$/"),
        "child_last_name.*" =>  array("required", "regex:/^[a-zA-Z\s]+$/"),
        "child_age.*" => "required|numeric",
        "child_gender.*" => "required",
        "child_different_address.*" => "nullable|accepted",
        "child_address.*" => "nullable|string",
        "child_city.*" => "nullable|string",
        "child_state.*" => "nullable|string",
        "child_country.*" => "nullable|string",
        "child_zip_code.*" => "nullable|numeric",
    ];


    /**
     * Display a listing of the resource.
     */
    public function index() {
        $children = Child::all();
        return view("children.index", ["children" => $children]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $validator = Validator::make($request->all(), $this->validationRules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            // Process the validated child data and update or create records
            $childData = $request->only($this->fieldNames);

            foreach ($childData["child_first_name"] as $index => $firstName) {

                $child_different_address = 0;

                if (!is_null($request->input("child_different_address")) && array_key_exists($index, $request->input("child_different_address"))) {
                    $child_different_address = $childData["child_different_address"][$index];
                    $child_different_address = ($child_different_address === "on") ? 1 : 0;
                }
                if (!is_null($request->input("id")) && array_key_exists($index, $request->input("id"))) {
                    $childId = $request->input("id")[$index];

                    if ($child_different_address === 0) {
                        Child::updateOrCreate(
                            // If id is found then update the record
                            ["id" => $childId],
                            [
                                "child_first_name" => $firstName,
                                "child_middle_name" => $childData["child_middle_name"][$index],
                                "child_last_name" => $childData["child_last_name"][$index],
                                "child_age" => $childData["child_age"][$index],
                                "child_gender" => $childData["child_gender"][$index],
                                "child_different_address" => $child_different_address,
                            ]
                        );
                    } else {

                        Child::updateOrCreate(
                            ["id" => $childId],
                            [
                                "child_first_name" => $firstName,
                                "child_middle_name" => $childData["child_middle_name"][$index],
                                "child_last_name" => $childData["child_last_name"][$index],
                                "child_age" => $childData["child_age"][$index],
                                "child_gender" => $childData["child_gender"][$index],
                                "child_different_address" => $child_different_address,
                                "child_address" => $childData["child_address"][$index],
                                "child_city" => $childData["child_city"][$index],
                                "child_state" => $childData["child_state"][$index],
                                "child_country" => $childData["child_country"][$index],
                                "child_zip_code" => $childData["child_zip_code"][$index],
                            ]
                        );
                    }
                } else {

                    if ($child_different_address === 0) {
                        Child::create([
                            "child_first_name" => $firstName,
                            "child_middle_name" => $childData["child_middle_name"][$index],
                            "child_last_name" => $childData["child_last_name"][$index],
                            "child_age" => $childData["child_age"][$index],
                            "child_gender" => $childData["child_gender"][$index],
                            "child_different_address" => $child_different_address,
                        ]);
                    } else {
                        Child::create([
                            "child_first_name" => $firstName,
                            "child_middle_name" => $childData["child_middle_name"][$index],
                            "child_last_name" => $childData["child_last_name"][$index],
                            "child_age" => $childData["child_age"][$index],
                            "child_gender" => $childData["child_gender"][$index],
                            "child_different_address" => $child_different_address,
                            "child_address" => $childData["child_address"][$index],
                            "child_city" => $childData["child_city"][$index],
                            "child_state" => $childData["child_state"][$index],
                            "child_country" => $childData["child_country"][$index],
                            "child_zip_code" => $childData["child_zip_code"][$index],
                        ]);
                    }
                }
            }
        }

        return redirect()->route("children.index")->with("status", ["success" => true, "message" => "Data Stored/Updated Successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */


    public function destroy(Child $child) {

        $child->delete();

        return redirect()->route("children.index")->with("status", ["success" => true, "message" => "Child record deleted successfully."]);
    }
}
