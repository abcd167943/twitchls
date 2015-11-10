@extends('layout')

@section('title', 'Twitch Stream List')

@section('content')
    <div class="container">


        <div class="row tabs">
            <ul class="nav nav-tabs">

                @if (isset($user))
                <li class="active" data-key="followed"><a href="#followed">Followed</a></li>
                <li data-key="all"><a href="#all">All</a></li>
                @else
                <li class="active" data-key="all"><a href="#all">All</a></li>
                @endif

                <li data-key="search"><a href="#search">Search</a></li>
            </ul>
        </div>

        <div id="vue" class="hidden">

            @if (isset($user))
            <div class="row streams followed">

                <stream v-for="stream in followed" :stream="stream"></stream>

                <div class="col-xs-12 loading">
                    <img v-show="followedLoading" class="center-block" src="/images/oval.svg">
                </div>
            </div>
            @endif

            <div class="row streams all">

                <form class="form-horizontal">
                    <div class="form-group">
                        <select class="col-xs-12 form-control" v-model="game" options="games">
                            <option v-for="game in games" v-bind:value="game.value">
                                @{{ game.text }}
                            </option>
                        </select>
                    </div>
                </form>

                <stream v-for="stream in streams" :stream="stream"></stream>

                <div class="col-xs-12 loading">
                    <button v-show="! loading" v-on:click="loadMoreStreams" class="btn btn-default center-block">Load more streams</button>
                    <img v-show="loading" class="center-block" src="/images/oval.svg">
                </div>
            </div>

            <div class="row streams search hidden">

                <form class="form-horizontal" id="searchForm">
                    <div class="form-group">
                        <input type="text" v-on:keyup="resetSearchResults" v-model="searchQuery" name="searchQuery" class="form-control col-xs-12" placeholder="Search..." debounce="600">
                    </div>
                </form>

                <stream v-for="stream in searchResults" :stream="stream"></stream>

                <div class="col-xs-12 loading">
                    <p v-show="(! searchLoading) && (searchResults.length == 0) && (searchQuery.length === 0)">Nothing to do.</p>
                    <p v-show="(! searchLoading) && (searchResults.length == 0) && (searchQuery.length !== 0)">No results for "@{{ searchQuery }}".</p>
                    <img v-show="searchLoading && (searchQuery.length !== 0)" class="center-block" src="/images/oval.svg">
                </div>
            </div>
        </div>
    </div>
@endsection
