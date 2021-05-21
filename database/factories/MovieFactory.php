<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;

    public function definition()
    {
        return [
            'title' => $this->faker->realText(20),
            'synopsis' => $this->faker->paragraph(rand(10, 20)),
            'year' => $this->faker->year,
            'poster' => $this->randomPoster(),
            'banner' => $this->randomBanner(),
            'trailer' => $this->randomTrailer(),
            'duration' => $this->faker->numberBetween($min = 50, $max = 300),
        ];
    }

    public function randomPoster()
    {
        $posters = Array(
            'https://townsquare.media/site/442/files/2019/08/ides-of-march-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/devil-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/zero-dark-thirty-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/rum-diary-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/us-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/bridesmaids-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/last-exorcism-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/the-lobster-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/amazing-spider-man-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/blackkklansman-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/central-park-five-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/childs-play-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/the-lion-king-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/baby-driver-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/dom-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/mission-impossible-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/doctor-sleep-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/carol-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/10-cloverfield-lane-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/the-front-runner-1.jpg?w=980&q=75',
            'https://media-cache.cinematerial.com/p/500x/kaynoyji/kimi-no-na-wa-japanese-movie-poster.jpg?v=1478802657',
            'https://townsquare.media/site/442/files/2019/08/nympho-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/christine-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/crimson-peak-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/thor-ragnarok-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/open-windows.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/painand-gain-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/forty-two-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/somewhere-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/star-wars-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/black-swan-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/buried-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/moonlight-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/walt-before-mickey-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/wonder-woman-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/star-is-born-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/blue-ruin-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/ballad-of-buster-scruggs-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/inception-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/burning-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/let-me-in.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/mother-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/the-love-witch-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/jurassic-world-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/first-reformed-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/john-wick-chapter-2.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/need-for-speed-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/lady-bird-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/neighbors-1.jpg?w=980&q=75',
            'https://townsquare.media/site/442/files/2019/08/lincoln-1.jpg?w=980&q=75'
        );

        return $posters[array_rand($posters)];
    }

    public function randomTrailer()
    {
        $trailers = [
            'https://www.youtube.com/embed/rrwBnlYOp4g',
            'https://www.youtube.com/embed/V67sjW5eyJU',
            'https://www.youtube.com/embed/GAau1QEOWns',
            'https://www.youtube.com/embed/QiCif7A2NRI',
            'https://www.youtube.com/embed/9JZ1nVH-dzg',
            'https://www.youtube.com/embed/RDOPiR5IAaI',
            'https://www.youtube.com/embed/mvGhDqz6oFM',
            'https://www.youtube.com/embed/fMbV1BDlmqQ',
            'https://www.youtube.com/embed/nW948Va-l10',
            'https://www.youtube.com/embed/wZti8QKBWPo',
        ];

        return $trailers[array_rand($trailers)];
    }

    public function randomBanner()
    {
        $banners = [
            'https://wallpapercave.com/wp/wp5223134.jpg',
            'https://wallpapercave.com/wp/wp7999745.jpg',
            'https://wallpaperaccess.com/full/889517.jpg',
            'https://wallpapercave.com/wp/wp3666962.jpg',
            'https://wallpapercave.com/wp/wp5539841.jpg',
            'https://images.wallpapersden.com/image/download/joaquin-phoenix-as-joker_a2lma2uUmZqaraWkpJRnamtlrWZpaWU.jpg',
            'https://images.hdqwalls.com/wallpapers/a-quiet-place-part-2-movie-n3.jpg',
            'https://wallpapercave.com/wp/wp4817824.jpg',
            'https://wallpaperaccess.com/full/1264684.jpg',
            'https://images.hdqwalls.com/wallpapers/up-movie-4k-fr.jpg',
            'https://trumpwallpapers.com/wp-content/uploads/WALL-E-Wallpaper-01-1920x1080-1.jpg',
            'https://i.pinimg.com/originals/f0/3a/2b/f03a2bcaf5c64e81aa6c494ffe98be6e.jpg',
            'https://cdn.hipwallpaper.com/i/8/44/hSHi6N.jpg',
            'https://wallpaperaccess.com/full/1707195.jpg',
            'https://studioghiblimovies.com/wp-content/uploads/2019/02/d78b1219f9991c69a7619d362548cb79f4d29e02_hq2.jpg',
            'https://wallpaperaccess.com/full/4190641.jpg',
            'https://wallpapercave.com/wp/wp3083904.jpg',
            'https://images2.alphacoders.com/742/thumb-1920-742320.png',
            'https://free4kwallpapers.com/uploads/originals/2019/11/20/bladerunner--movie-scene-wallpaper.jpg'
        ];

        return $banners[array_rand($banners)];
    }
}
