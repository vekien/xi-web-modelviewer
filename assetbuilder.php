<?php

$assets = [
    'Gear' => [],
    'NPC1' => [],
    'NPC2' => [],
    'Weapons' => [],
    'Zones' => []
];

$anims = [];

foreach(array_keys($assets) as $assetName) {
    echo "---> {$assetName}\n";

    $directory = "../{$assetName}";

    // Create a recursive iterator to iterate through the directory
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    // Loop through the iterator
    foreach ($iterator as $file) {
        // Check if the current item is a file and ends with '.fbx' extension
        if ($file->isFile() && $file->getExtension() === 'fbx') {
            $path = $file->getPathname();
            $path = str_ireplace("\\", "/", $path);;

            // handle gear
            if ($assetName == "Gear") {
                [$a, $type, $race, $slot, $name, $filename] = explode("/", $path);

                echo "{$race} - {$slot} - {$name} \n";

                $assets[$assetName][] = [
                    'name' => "{$race} - {$slot} - {$name}",
                    'category' => $assetName,
                    'file' => $path,
                    'scale' => 3,
                    'anims' => false,
                ];
            }

            // handle npc 1
            if ($assetName == "NPC1") {
                // if this is an anim, append to anim lists
                if (stripos($path, 'noefbxmulti')) {
                    $basepath = dirname($path);
                    $anims[$basepath][] = $path;
                    continue;
                }

                [$a, $type, $race, $name] = explode("/", $path);

                echo "{$race} - {$name} \n";

                $assets[$assetName][] = [
                    'name' => "{$race} - {$name}",
                    'category' => $assetName,
                    'file' => $path,
                    'scale' => 1,
                    'anims' => false,
                ];
            }

            // handle npc 2
            if ($assetName == "NPC2") {
                [$a, $type, $zone, $name] = explode("/", $path);

                echo "{$zone} - {$name} \n";

                $assets[$assetName][] = [
                    'name' => "{$zone} - {$name}",
                    'category' => $assetName,
                    'file' => $path,
                    'scale' => 1,
                    'anims' => false,
                ];
            }

            // handle weapons
            if ($assetName == "Weapons") {
                [$a, $type, $slot, $type, $name] = explode("/", $path);

                echo "{$slot} - {$type} - {$name} \n";

                $assets[$assetName][] = [
                    'name' => "{$slot} - {$type} - {$name}",
                    'category' => $assetName,
                    'file' => $path,
                    'scale' => 3,
                    'anims' => false,
                ];
            }

            // handle zones
            if ($assetName == "Zones") {
                [$a, $type, $expansion, $name] = explode("/", $path);

                // ignore doors and subrooms
                if ($expansion == "_Doors") {
                    continue;
                }

                echo "{$expansion} - {$name} \n";

                $assets[$assetName][] = [
                    'name' => "{$expansion} - {$name}",
                    'category' => $assetName,
                    'file' => $path,
                    'scale' => 0.1,
                    'anims' => false,
                ];
            }
        }
    }
}

echo "\n-- APPENDING NPC 1 ANIMS --\n";

foreach ($assets['NPC1'] as $i => $npc1) {
    $file = $npc1['file'];
    $dirname = dirname($file);

    // grab anims
    $animFiles = $anims[$dirname] ?? null;
    $animList = [];

    if ($animFiles) {
        foreach($animFiles as $filename) {
            $animList[] = [
                'name' => trim(explode("-", str_ireplace(".fbx", "", $filename))[1]),
                'file' => $filename
            ];
        }

        $assets['NPC1'][$i]['file_anims'] = $animList;
        $assets['NPC1'][$i]['anims'] = true;
    }
}

echo "\n-- SAVING JSON --\n";

file_put_contents(__DIR__ .'/assets.json', json_encode($assets, JSON_PRETTY_PRINT));

echo("\n-- FINISHED --\n");