<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class EquipeController extends Controller
{
    public function index()
    {

        $equipes = Equipe::all();
        $semequipes = (new User())->vendedores_sem_equipes();

        $users = (new User())->vendedores();

        return view('equipes.index', compact('equipes', 'semequipes', 'users'));
    }
    function getRandomColor()
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    public function organograma()
    {

        // Obter todas as equipes e seus líderes
        $equipes = Equipe::all();

        // Array para armazenar o organograma
        $organogramData = [
            'id' => 'SEM EQUIPE',
            'data' => [
                "imageURL" => url('') . "/images/users/user_" . 1 . "/avatar.png",
                'name' => User::find(1)->name,
            ],
            'options' => [
                'nodeBGColor' => $this->getRandomColor(),
                'nodeBGColorHover' => '#cdb4db',
            ],
            'children' => []
        ];

        foreach ($equipes as $equipe) {
            // Estrutura do líder da equipe como nó principal
            $liderNode = [
                'id' => 'equipe_' . $equipe->id,
                'data' => [
                    "imageURL" => url('') . "/images/users/user_" .  $equipe->lider->id . "/avatar.png",
                    'name' => $equipe->lider->name,
                ],
                'options' => [
                    'nodeBGColor' => $this->getRandomColor(),
                    'nodeBGColorHover' => '#cdb4db',
                ],
                'children' => []
            ];

            // Adicionar os integrantes da equipe como filhos do líder
            foreach ($equipe->integrantes as $integrante) {
                // Evitar adicionar o líder novamente como integrante
                if ($integrante->id !== $equipe->lider->id) {
                    $liderNode['children'][] = [
                        'id' => 'integrante_' . $integrante->id,
                        'data' => [
                            // 'imageURL' => url('images/avatars/' . $integrante->avatar),
                            "imageURL" => url('')."/images/users/user_". $integrante->id."/avatar.png",
                            'name' => $integrante->name,
                        ],
                        'options' => [
                            'nodeBGColor' => $this->getRandomColor(),
                            'nodeBGColorHover' => '#ffafcc',
                        ]
                    ];
                }
            }

            // Adicionar o nó do líder e seus filhos ao organograma principal
            $organogramData['children'][] = $liderNode;
        }


        // Estrutura de dados do organograma
        $data = [
            "id" => "ms",
            "data" => [
                "imageURL" => "https://i.pravatar.cc/300?img=68",
                "name" => "Margret Swanson"
            ],
            "options" => [
                "nodeBGColor" => "#cdb4db",
                "nodeBGColorHover" => "#cdb4db"
            ],
            "children" => [
                [
                    "id" => "mh",
                    "data" => [
                        "imageURL" => "https://i.pravatar.cc/300?img=69",
                        "name" => "Mark Hudson"
                    ],
                    "options" => [
                        "nodeBGColor" => "#ffafcc",
                        "nodeBGColorHover" => "#ffafcc"
                    ],
                    "children" => [
                        [
                            "id" => "kb",
                            "data" => [
                                "imageURL" => "https://i.pravatar.cc/300?img=65",
                                "name" => "Karyn Borbas"
                            ],
                            "options" => [
                                "nodeBGColor" => "#f8ad9d",
                                "nodeBGColorHover" => "#f8ad9d"
                            ]
                        ],
                        [
                            "id" => "cr",
                            "data" => [
                                "imageURL" => "https://i.pravatar.cc/300?img=60",
                                "name" => "Chris Rup"
                            ],
                            "options" => [
                                "nodeBGColor" => "#c9cba3",
                                "nodeBGColorHover" => "#c9cba3"
                            ]
                        ]
                    ]
                ],
                [
                    "id" => "cs",
                    "data" => [
                        "imageURL" => "https://i.pravatar.cc/300?img=59",
                        "name" => "Chris Lysek"
                    ],
                    "options" => [
                        "nodeBGColor" => "#00afb9",
                        "nodeBGColorHover" => "#00afb9"
                    ],
                    "children" => [
                        [
                            "id" => "Noah_Chandler",
                            "data" => [
                                "imageURL" => "https://i.pravatar.cc/300?img=57",
                                "name" => "Noah Chandler"
                            ],
                            "options" => [
                                "nodeBGColor" => "#84a59d",
                                "nodeBGColorHover" => "#84a59d"
                            ]
                        ],
                        [
                            "id" => "Felix_Wagner",
                            "data" => [
                                "imageURL" => "https://i.pravatar.cc/300?img=52",
                                "name" => "Felix Wagner"
                            ],
                            "options" => [
                                "nodeBGColor" => "#0081a7",
                                "nodeBGColorHover" => "#0081a7"
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $data = [
            "id" => "ms",
            "data" => [
                "imageURL" => "https://i.pravatar.cc/300?img=68",
                "name" => "Margret Swanson"
            ],
            "options" => [
                "nodeBGColor" => "#cdb4db",
                "nodeBGColorHover" => "#cdb4db"
            ],
            "children" => [
                [
                    "id" => "mh",
                    "data" => [
                        "imageURL" => "https://i.pravatar.cc/300?img=69",
                        "name" => "Mark Hudson"
                    ],
                    "options" => [
                        "nodeBGColor" => "#ffafcc",
                        "nodeBGColorHover" => "#ffafcc"
                    ],

                ],

            ]
        ];


        // Retornar o organograma em formato JSON
        return response()->json($organogramData);

    }


    public function equipe_get(Request $request)
    {

        $id = $request->query('id');
        $equipe = Equipe::find($id);

        $lider = $equipe->lider_id;

        $user = User::find($equipe->lider_id);

        return [$equipe->id, $equipe->nome, $user->name, $equipe->descricao, $equipe->logo, $equipe->lider_id];
    }

    public function change_image(Request $request)
    {
        $input = $request->all();


        $equipe = Equipe::find($input['editar_equipe_id']);
        if ($request->hasFile('image')) {
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
            );

            $error_msg = [
                'image.max' => 'Limite Máximo do Arquivo 3mb',
                'image.mimes' => 'extensões válidas (jpg,png,jpeg,gif,svg)'
            ];

            $validator = Validator::make($input, $rules, $error_msg);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $imageName = "logo." . $request->image->extension();
            $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
            $equipe->logo = $imageName;
        }


        $equipe->save();

        return back()->with("status", "Equipe Editada com sucesso");
    }


    public function change_equipe(Request $request)
    {

        $input = $request->all();


        $equipe = Equipe::find($input['editar_equipe_id']);
        if ($request->has('lider_id')) {

            if ($input['lider_id'] != '' && $input['lider_id'] != $equipe->lider_id) {

                $antigolider = User::find($equipe->lider_id);
                User::where('id', $antigolider->id)->update(['equipe_id' => NULL]);

                $novolider = User::find($input['lider_id']);
                $equipe->lider_id = $novolider->id;

                User::where('id', $novolider->id)->update(['equipe_id' => $equipe->id]);
            }
        }

        $nome_equipe = $input['edit_nome_equipe'];
        $equipe->descricao = $nome_equipe;


        $nome_equipe = strtolower(trim(preg_replace("/[^A-Za-z0-9]/", '_', $nome_equipe)));
        $equipe->nome = $nome_equipe;

        if ($request->hasFile('image')) {
            $rules = array(
                'image' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
            );

            $error_msg = [
                'image.max' => 'Limite Máximo do Arquivo 3mb',
                'image.mimes' => 'extensões válidas (jpg,png,jpeg,gif,svg)'
            ];

            $validator = Validator::make($input, $rules, $error_msg);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }


            $imageName = "logo." . $request->image->extension();
            $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
            $equipe->logo = $imageName;
        }


        $equipe->save();

        return back()->with("status", "Equipe Editada com sucesso");
    }

    public function create(Request $request)
    {

        $input = $request->all();

        $rules = array(
            'image' => 'mimes:jpg,png,jpeg,gif,svg|max:2048',
        );

        $error_msg = [

            'image.max' => 'Limite Máximo do Arquivo 3mb',
            'image.mimes' => 'extensões válidas (jpg,jpeg,png,jpeg,gif,svg)'
        ];

        $validator = Validator::make($input, $rules, $error_msg);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $equipe = new Equipe();
        $nome_equipe = $input['nome_equipe'];

        $equipe->descricao = $nome_equipe;

        $nome_equipe = strtolower(trim(preg_replace("/[^A-Za-z0-9]/", '_', $nome_equipe)));

        $equipe->nome = $nome_equipe;

        $equipe->lider_id = $input['lider_id'];

        if ($request->hasFile('image')) {
            $imageName = "logo." . $request->image->extension();
            $equipe->logo = $imageName;
            $equipe->save();

            $request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
        } else {
            $equipe->logo = 'images/sistema/equipe-padrao.png';


            #$request->image->move(public_path('images') . "/equipes/" . $equipe->id . "/", $imageName);
        }


        $equipe->save();


        User::where('id', $input['lider_id'])->update(['equipe_id' => $equipe->id]);

        return back()->with("status", "Equipe Criada com sucesso");
    }

    public function excluir(Request $res)
    {
        $input = $res->input();
        $equipe = Equipe::find($input['excluir_equipe_id']);

        $exists_int = false;
        foreach ($equipe->integrantes()->get() as $integrante) {
            if ($integrante->id != $equipe->lider_id) {
                $exists_int = true;
                break;
            }
        }

        if ($exists_int) {
            return back()->withErrors("Retire os Integrantes antes de deletar uma equipe");
        }

        User::where('id', $equipe->lider_id)->update(['equipe_id' => NULL]);
        $equipe->delete();

        return back()->with("status", "Equipe Excluida com sucesso");
    }
    public function drag_update(Request $res)
    {

        $input = $res->input();
        $id_funcionario = $input['info'][0];
        $id_origem = $input['info'][1];
        $id_destino = $input['info'][2];

        $funcionario = User::find($id_funcionario);

        if ($id_destino > 0) {
            $funcionario::where('id', $id_funcionario)->update(['equipe_id' => $id_destino]);
        } else {
            $funcionario::where('id', $id_funcionario)->update(['equipe_id' => NULL]);
        }

    }
}
