<?php

namespace App\Parser;


use App\Entity\Instagram;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Environment;

class Parser
{
    private Api $api;
    private EntityManagerInterface $entityManager;
    private Environment $environment;

    public function __construct(
        Api                    $api,
        EntityManagerInterface $entityManager,
        Environment $environment,
    )
    {
        $this->api = $api;
        $this->entityManager = $entityManager;
        $this->environment = $environment;
    }

    public function handle(Instagram $instagram, string $result = 'all'): array
    {
        if ($login = $this->getLogin($instagram->getLogin())) {
            $data = $this->api->request($login);

            if (isset($data['data']['user'])) {
                $user = $data['data']['user'];

                $photos = [];

                foreach ($user['edge_owner_to_timeline_media']['edges'] as $edge){
                    $photos[] = $edge['node']['display_url'];
                }

                $instagram->setAvatar($user['profile_pic_url'])
                    ->setCreatedAt(new \DateTimeImmutable())
                    ->setSubscribers($user['edge_followed_by']['count'])
                    ->setSubscriptions($user['edge_follow']['count'])
                    ->setLogin($user['username'])
                    ->setPhotos($photos);

                $this->entityManager->persist($instagram);
                $this->entityManager->flush();


                if($result == 'all') {
                    return [
                        'status' => 1,
                        'result' => [
                            'messages' => 'Данные о аккаунте получены',
                            'html' => $this->environment->render('main/parse.items.html.twig', [
                                'item' => $instagram,
                            ]),
                        ]
                    ];
                } else {
                    return [
                        'status' => 1,
                        'data' => [
                            'avatar' => $instagram->getAvatar(),
                            'login' => $instagram->getLogin(),
                            'subscriptions' => $instagram->getSubscriptions(),
                            'subscribers' => $instagram->getSubscribers(),
                            'photos' => (function($photo){
                                $array = [];
                                foreach ($photo as $item){
                                    $array[] = [
                                        'item' => $item
                                    ];
                                }
                                return $array;
                            })($instagram->getPhotos()),
                        ]
                    ];
                }
            }
            return ['status' => 0, 'error' => ['messages' => 'Ошибка при подключение к инсте.']];
        }
        return ['status' => 0, 'error' => ['messages' => 'Не верный ник!']];
    }

    public function getLogin(string $url): float|bool|int|string
    {
        if (is_numeric($url)) {
            return $url;
        }
        if (mb_strpos($url, 'https://') > -1) {
            $url = mb_substr($url, 8);
        }
        $parts = explode('/', $url);

        if (('instagram.com' === $parts[0] || 'www.instagram.com' === $parts[0])) {
            return $parts[1];
        }
        return $parts[0];
    }
}
