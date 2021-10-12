<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
                'name' => 'Metal garland',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc faucibus, justo sit amet interdum aliquam, velit nunc porta sapien, ac efficitur massa felis in ipsum. Ut at scelerisque eros. Phasellus vitae nibh scelerisque, consequat turpis at, viverra augue. Aliquam accumsan libero ut dapibus auctor. Duis pulvinar neque ipsum, pulvinar fringilla.',
                'price' => 9.75,
                'stock' => 3,
            ],
            [
                'name' => 'Christmas Wreath Pop Up Card',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi massa est, pellentesque et lacus sit amet, volutpat porta dolor. Aenean mollis orci ut magna dignissim tristique. Phasellus tristique lorem sed quam placerat, nec consequat lorem mollis. Phasellus vel ultrices enim, vel gravida mi. Donec at libero tortor. Morbi vitae tortor.',
                'price' => 6.99,
                'stock' => 5,
            ],
            [
                'name' => 'Christmas Snowman',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam elit nibh, semper vel consectetur in, tristique in urna. Vivamus ornare nunc sit amet ex mattis ultrices. Praesent neque turpis, pellentesque nec augue a, scelerisque venenatis quam. Vestibulum tempor cursus tortor eget posuere. Aenean odio ante, aliquet et pulvinar in, volutpat.',
                'price' => 5.00,
                'stock' => 20,
            ],
            [
                'name' => 'Shining Angel',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis feugiat faucibus justo imperdiet consectetur. Integer elementum ultricies leo vel semper. Phasellus ac urna hendrerit, pulvinar massa in, ornare quam. Etiam enim augue, pretium sit amet aliquam a, imperdiet id ipsum. Sed sodales auctor orci, in suscipit purus bibendum auctor. Sed.',
                'price' => 3.20,
                'stock' => 1,
            ],
            [
                'name' => 'White LED Christmas Tree Bulb',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras eu pharetra neque. Curabitur lacus lectus, tristique vel turpis id, fringilla semper dui. Vivamus non lobortis enim. Sed feugiat sapien orci, quis semper diam sodales sit amet. Donec sit amet urna lorem. Quisque finibus feugiat leo, sodales vestibulum arcu malesuada et.',
                'price' => 2.99,
                'stock' => 50,
            ],
            [
                'name' => 'Regular String Light',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vitae dui vitae turpis cursus porttitor sed eget sapien. Mauris faucibus tincidunt velit, nec pulvinar ex elementum et. Quisque nisl nunc, pellentesque sed ultrices nec, laoreet id velit. Quisque dapibus diam in lacinia laoreet. Aliquam sed porttitor massa. Suspendisse maximus euismod.',
                'price' => 2.40,
                'stock' => 5,
            ],
            [
                'name' => 'Shining Window Star',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ac sapien enim. Morbi consectetur vel enim ac gravida. In hac habitasse platea dictumst. Proin ultrices risus ut tortor convallis porta. Duis viverra nulla ac magna fringilla cursus. Nunc vitae tincidunt lectus. Cras consectetur urna non consectetur congue. Integer ultrices augue.',
                'price' => 4.50,
                'stock' => 3,
            ],
            [
                'name' => 'Christmas card',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed rhoncus et quam sed scelerisque. Nullam quis lorem felis. Sed ullamcorper magna eu ex venenatis, a viverra justo tempus. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis eu leo ante. Nullam commodo, sapien sed vehicula posuere.',
                'price' => 9.50,
                'stock' => 10,
            ],
            [
                'name' => 'Honey Almond Bread',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sodales nibh nisl, et aliquet magna tempor ac. Donec at lacinia leo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur eu lorem eget nibh sollicitudin hendrerit a.',
                'price' => 1.70,
                'stock' => 20,
            ],
            [
                'name' => 'Discovery box',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum ut accumsan tellus, sit amet volutpat tortor. Donec finibus, dolor vel varius tincidunt, augue velit pretium elit, non ultricies ligula justo auctor quam. Suspendisse fringilla et quam eget vehicula. Pellentesque in lorem massa. Integer a ante ultrices, pretium nisl quis, elementum.',
                'price' => 9.60,
                'stock' => 12,
            ],
            [
                'name' => 'Box of chocolates heart',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultrices congue orci, ut rhoncus risus convallis in. Ut placerat ex ipsum, nec suscipit massa eleifend vel. Nulla neque ipsum, feugiat sit amet condimentum sit amet, gravida ac sapien. Cras a pretium ex. Quisque porta ex non aliquam viverra. Nulla facilisi.',
                'price' => 11.20,
                'stock' => 15,
            ],
            [
                'name' => 'Caramel Hazelnuts',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ultrices, neque quis hendrerit scelerisque, sem neque hendrerit lectus, eget scelerisque felis lorem ut lectus. Proin laoreet mauris et felis fringilla, sed dignissim dolor pharetra. Sed sodales tortor et purus fringilla, sit amet ultricies enim pulvinar. Maecenas erat ipsum, molestie at.',
                'price' => 3.70,
                'stock' => 1,
            ],
            [
                'name' => 'Vanilla from Madagascar',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit nibh tellus, ut porttitor lacus efficitur eget. Sed eleifend ut metus eget varius. Nunc condimentum nec sem ac blandit. Sed lacinia lorem ac felis interdum vulputate. Duis molestie, tellus sed posuere interdum, augue mauris ultricies sapien, vel aliquam justo nibh.',
                'price' => 4.60,
                'stock' => 30,
            ],
            [
                'name' => 'Dehydrated pear',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque maximus eros a erat varius, in convallis nibh porttitor. Donec gravida urna non ligula volutpat, eu feugiat augue molestie. Nam faucibus nec libero id tempor. Vivamus mollis interdum egestas. Fusce diam turpis, efficitur sit amet dolor at, sollicitudin condimentum augue. Aliquam.',
                'price' => 1.90,
                'stock' => 20,
            ],
            [
                'name' => 'Caramel toffee syrup',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sit amet sodales ex, in hendrerit diam. Nulla facilisi. Sed at nunc libero. Phasellus ac aliquam sem. Vestibulum semper eget lectus eget aliquet. Sed vehicula nulla non lorem pellentesque, a sollicitudin lorem ultrices. Nulla non mauris vulputate, posuere leo quis, mattis.',
                'price' => 1.49,
                'stock' => 13,
            ],
            [
                'name' => 'Ceramic mug Christmas',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lacinia porttitor sollicitudin. Praesent libero augue, ornare at tellus accumsan, molestie feugiat sapien. Suspendisse id tortor a turpis dapibus rhoncus vel eu lorem. In accumsan, nibh ac consectetur molestie, lorem diam fermentum nisl, eu laoreet risus enim id felis. Donec aliquet.',
                'price' => 4.90,
                'stock' => 3,
            ],
            [
                'name' => 'Teapot Gold Christmas',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras rutrum, libero vel bibendum tincidunt, felis sem ornare velit, et commodo enim nisl at leo. Etiam magna lectus, placerat sit amet scelerisque non, scelerisque eget sem. Etiam et aliquet augue. In at dolor id nisi facilisis iaculis sed non ligula. Curabitur.',
                'price' => 6.00,
                'stock' => 15,
            ],
            [
                'name' => 'Xmas Knit Table Runner',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam ullamcorper vulputate ligula, id laoreet risus fermentum a. Fusce id purus sit amet enim placerat consequat. Aenean mattis tortor neque, ac tempus lorem auctor ac. Integer nec sem metus. Morbi dapibus egestas tellus, quis efficitur lectus aliquet ac. Curabitur quis consectetur.',
                'price' => 1.80,
                'stock' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::factory()->create($product);
        }
    }
}
