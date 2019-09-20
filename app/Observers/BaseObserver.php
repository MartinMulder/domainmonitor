<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class BaseObserver
{
	protected function getModelChanges(Model $model)
	{
		if (is_array($model->trackChanges))
		{
			// Translate array values to keys
			$trackChanges = array_flip($model->trackChanges);

			// Get the notifiable changes
			$notifiable = array_intersect_key($model->getChanges(), $trackChanges);	

			$str = "";
			
			foreach($notifiable as $key => $val) {
				$str .= $key . ' => ' . $val . "\n";
			}
			//return $notifiable;		
			return $str;

		}
		return false;
	}
}