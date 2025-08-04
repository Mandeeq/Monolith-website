<?php
namespace crm;

/**
 * @license Apache 2.0
 */
/**
 * @OA\Info(
 *     description="API documentation for crm module",
 *     version="1.0.0",
 *     title="crm Module",
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
    public $controllerNamespace = 'crm\controllers';
    public $name = 'crm';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@app/providers/interface/views/crm/');
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
 *     name="CRM",
 *     description="Endpoints for the CRM module"
 * )
 */

/**
 * @OA\Get(path="/about",
 *   summary="Module Info. ",
 *   tags={"CRM"},
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
 *  @OA\Property(property="id", type="string",title="Module ID", example="CRM"),
 *  @OA\Property(property="name", type="string",title="Module Name", example="CRM Module"),
 * )
 */