<?php

/**
 * Re format the features list of the websites
 * 
 * @param array $list
 * @param array $loadedFeatures
 * 
 * @return array
 */
function reformat_features($list, $loadedFeatures = []) {
    
    if(empty($loadedFeatures)) return $list;
    
    $keyValues = [];
    foreach($loadedFeatures as $key => $value) {
        $keyValues[$value['initial']] = strtolower(str_ireplace(" ", "_", $value['name']));
    }

    foreach($list as $item) {
        $websiteFeatures[] = $keyValues[$item] ?? $item;
    }

    return $websiteFeatures ?? [];
}