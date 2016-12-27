<?php

namespace App\Http\Composer;

use Illuminate\View\View;
use App\Model\Category;

class ViewComposer
{

    /**
     * Categories variable
     * 
     * @var type 
     */
    protected $_categories = [];

    /**
     * Construct
     */
    public function __construct()
    {
        $this->_categories = Category::all();
    }

    /**
     * Compose
     */
    public function compose(View $view)
    {
        $view->with('_categories', $this->_categories);
    }

}
