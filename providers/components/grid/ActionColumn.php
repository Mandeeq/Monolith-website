<?php

namespace helpers\grid;

class ActionColumn extends \yii\grid\ActionColumn
{
    public function init()
    {
        $this->contentOptions = [
            'style' => 'display: flex; align-items: center; justify-content: center; gap: 2px;',
            'class' => 'action-column',
        ];
        parent::init(); // Don't forget this!
    }
}
