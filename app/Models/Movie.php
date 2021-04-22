<?php

namespace App\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function watchlists() {
        return $this->belongsToMany(Watchlist::class, 'movie_watchlist');
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'genre_movie');
    }

    public function celebs() {
        return $this->belongsToMany(Celeb::class, 'celeb_movie')
            ->withPivot('character_name');
    }

    public function getDurationAttribute() {
        return CarbonInterval::minutes($this->attributes['duration'])->cascade()->forHumans(['short' => true]);
    }

    public static function randomPoster()
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

    public static function randomTrailer()
    {
        $trailers = [
            'https://www.youtube.com/watch?v=W-8_Y0_wMFc&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=1',
            'https://www.youtube.com/watch?v=6yi9P7NEnMQ&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=6',
            'https://www.youtube.com/watch?v=wNAhDaPaKRM&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=7',
            'https://www.youtube.com/watch?v=61_hWww9pnk&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=8',
            'https://www.youtube.com/watch?v=Da3STcxIUqw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=9',
            'https://www.youtube.com/watch?v=NjG5vxAe1eY&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=13',
            'https://www.youtube.com/watch?v=YUj-niW2sl8&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=18',
            'https://www.youtube.com/watch?v=P8aa4wtH_UE&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=20',
            'https://www.youtube.com/watch?v=k7ILRVC4FGQ&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=22',
            'https://www.youtube.com/watch?v=5JsZ2bAl3Jk&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=35',
            'https://www.youtube.com/watch?v=fgqEyC19538&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=41',
            'https://www.youtube.com/watch?v=mYmQkxiqn20&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=45',
            'https://www.youtube.com/watch?v=CHT8era7GOk&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=54',
            'https://www.youtube.com/watch?v=dvaycRwzsxA&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=64',
            'https://www.youtube.com/watch?v=WhLTyBUpUmg&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=61',
            'https://www.youtube.com/watch?v=_dikcPOJBqk&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=67',
            'https://www.youtube.com/watch?v=gjs6lKhedwg&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=72',
            'https://www.youtube.com/watch?v=06g6kHWNQoE&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=75',
            'https://www.youtube.com/watch?v=8ibK_JRC7Xw&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=88',
            'https://www.youtube.com/watch?v=RSXc5z9F7Do&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=96',
            'https://www.youtube.com/watch?v=5upIB9kxdvM&list=PLuAiHxLeTqiTeCoAiB39PUYALbxKprq6e&index=106',
        ];

        return $trailers[array_rand($trailers)];
    }

    public static function randomBanner()
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
