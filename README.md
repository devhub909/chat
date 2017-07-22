[![Downloads](https://img.shields.io/packagist/dt/musonza/chat.svg?style=flat-square)](https://packagist.org/packages/musonza/chat)
[![StyleCI](https://styleci.io/repos/54214978/shield?branch=master)](https://styleci.io/repos/54214978)
## Chat 

- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
  - [Creating a conversation](#creating-a-conversation)
  - [Get a conversation by Id](#get-a-conversation-by-id)
  - [Send a text message](#send-a-text-message)
  - [Send a message of custom type](#send-a-message-of-custom-type)
  - [Mark a message as read](#mark-a-message-as-read)
  - [Mark whole conversation as read](#mark-whole-conversation-as-read)
  - [Delete a message](#delete-a-message)
  - [Clear a conversation](#clear-a-conversation)
  - [Get a conversation between two users](#get-a-conversation-between-two-users)
  - [Remove users from a conversation](#remove-users-from-a-conversation)
  - [Add users to a conversation](#add-users-to-a-conversation)
  - [Get messages in a conversation](#get-messages-in-a-conversation)
  - [Get recent messages](#get-recent-messages)
  - [Get users in a conversation](#get-users-in-a-conversation)
- [License](#license)

## Introduction

This package allows you to add a chat system to your Laravel ^5.3 application

> **Note:** If you are using a Laravel version less than 5.3 [install the release on this branch instead](https://github.com/musonza/chat/tree/1.0).

## Installation

From the command line, run:

```
composer require musonza/chat
```

Add the service provider to your `config\app.php` the providers array

```
Musonza\Chat\ChatServiceProvider
```

Add the Facade to your aliases:

```
'Chat' => Musonza\Chat\Facades\ChatFacade::class to your `config\app.php`
```

The class is bound to the ioC as chat

```
$chat = App::make('chat');
```

Publish the assets:

```
php artisan vendor:publish
```

This will publish database migrations and a configuration file `musonza_chat.php` in the Laravel config folder.

> **Note:** This package takes advantage of Laravel Notifications. 
If you have already setup Laravel notifications you can delete the `2017_07_12_034227_create_notifications_table.php` migration file.

Run the migrations:

```
php artisan migrate
```

## Usage

By default the package assumes you have a User model in the App namespace. 

However, you can update the user model in `musonza_chat.php` published in the `config` folder.

#### Creating a conversation
```
$participants = [$userId, $userId2,...];

$conversation = Chat::createConversation($participants); 
```

#### Get a conversation by id
```
$conversation = Chat::conversation($conversation_id);
```

#### Send a text message

```{php}
$message = Chat::message('Hello')
            ->from($users[0]->id)
            ->to($conversation->id)
            ->send(); 
```
#### Send a message of custom type

The default message type is `text`. If you want to specify custom type you can call the `type()` function as below:

```php
$message = Chat::message('Hello')
		->type('image')
		->from($user->id)
		->to($conversation->id)
		->send(); 
```


#### Mark a message as read

```php
Chat::messages($message)->for($user)->markRead();
```

#### Mark whole conversation as read

```
Chat::conversations($conversation)->for($users[0])->readAll();
```	

#### Delete a message

```php
Chat::messages($message)->for($user)->delete();
```

#### Clear a conversation

```
Chat::conversations($conversation)->for($user)->clear();
```

#### Get a conversation between two users

```
Chat::getConversationBetween($user1, $user2);
```

#### Remove users from a conversation

```
/* removing one user */
Chat::removeParticipants($conversation, $user);
```

```
/* removing multiple users */
Chat::removeParticipants($conversation, [$user1, $user2, $user3,...,$userN]);
```

#### Add users to a conversation

```
/* add one user */
Chat::addParticipants($conversation->id, $user->id); 
```

```
/* add multiple users */
Chat::addParticipants($conversation->id, [$user3, $user4]);
```

<b>Note:</b> A third user will classify the conversation as not private if it was.


#### Get messages in a conversation

```
Chat::conversations($conversation)->for($users)->getMessages($perPage, $page)
```

#### Get recent messages 

```
$messages = Chat::conversations()->for($users)->limit(25)->page(1)->get();
```

#### Get users in a conversation

```
$users = $conversation->users;
```

## License

Chat is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)



