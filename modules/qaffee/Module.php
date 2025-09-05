<?php
namespace qaffee;

/**
 * @license Apache 2.0
 */
/**
 * @OA\Info(
 *     description="API documentation for qaffee module",
 *     version="1.0.0",
 *     title="qaffee Module",
 *     @OA\Contact(
 *         email="admin@crackit.co.ke",
 *         name="Ananda Douglas"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */ 

class Module extends \helpers\ApiModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'qaffee\controllers';
    public $name = 'qaffee';
    public $layout = 'admin';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
           $this->layoutPath = '@app/providers/interface/views/layouts'; // set this explicitly

    }

}

/**
 * @OA\SecurityScheme(
 *   securityScheme="bearerAuth",
 *   type="http",
 *   scheme="bearer",
 *   bearerFormat="JWT",
 * )
 */

/**
 * @OA\OpenApi(
 *   security={
 *      {
 *          "bearerAuth":{
 *
 *          }
 *      }
 *   }
 * )
 */

/**
 * @OA\Tag(
 *     name="QAFFEE",
 *     description="Endpoints for the QAFFEE module"
 * )
 */

/**
 * @OA\Get(path="/about",
 *   summary="Module Info. ",
 *   tags={"QAFFEE"},
 *   security={{}},
 *   @OA\Response(
 *     response=200,
 *     description="success",
 *      @OA\JsonContent(
 *          @OA\Property(property="data", type="array",@OA\Items(ref="#/components/schemas/About")),
 *          
 *      )
 *   ),
 * )
 */
/**
 *@OA\Schema(
 *  schema="About",
 *  @OA\Property(property="id", type="string",title="Module ID", example="QAFFEE"),
 *  @OA\Property(property="name", type="string",title="Module Name", example="QAFFEE Module"),
 * )
 */