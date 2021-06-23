@extends('layouts.primary')

@section('title', $post->title)

@section('bread_list')
<ul class="bread-list">
    <li><a href={{ route('eshop.home') }}>Home<i class="ti-arrow-right"></i></a></li>
    <li><a href={{ route('posts.index') }}>Blogs<i class="ti-arrow-right"></i></a></li>
    <li class="active"><a href={{ route('post.single',$post->slug) }}>
    {{ $post->title }}
    </a></li>
</ul>
@endsection

@section('content')
@include('partials._breadcumb')

<!-- blog only section -->
<!-- Start Blog Single -->
<section class="blog-single section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="blog-single-main">
                    <div class="row">
                        <div class="col-12">
                            <div class="image">
                                <img src="{{$post->image == ''?'https://via.placeholder.com/950x460':image_crop($post->image,950,460)}}" alt="#">
                            </div>
                            <div class="blog-detail">
                                <h2 class="blog-title">{{ $post->title }}</h2>
                                <div class="blog-meta">
                                    <span class="author"><a href="#"><i class="fa fa-user"></i>By {{$post->user->name}}</a><a
                                            href="#"><i class="fa fa-calendar"></i>{{ $post->created_at->diffForHumans() }}</a><a href="#comments"><i
                                                class="fa fa-comments"></i>Comment ({{$post->comments->count()}})</a></span>
                                </div>
                                <div>
                                    <p class="text-info mb-4"> Category: {{$post->category->name}}</p>
                                </div>
                                <div class="content">
                                    <p>{{ $post->body }}</p>
                                </div>
                            </div>

                            {{-- <div class="share-social">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="content-tags">
                                            <h4>Tags:</h4>
                                            <ul class="tag-inner">
                                                <li><a href="#">Glass</a></li>
                                                <li><a href="#">Pant</a></li>
                                                <li><a href="#">t-shirt</a></li>
                                                <li><a href="#">swater</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="col-12">
                            <div class="comments" id="comments">
                                <h3 class="comment-title">Comments ({{$post->comments->count()}})</h3>
                                <?php
                                function generateCommentsList($comment,$spaceCount = 0){
                                ?>
                                @if ($comment->parent_id > 0)
                                <p class="my-3" style="color: #3333ff">
                                    {!!str_repeat('#',$spaceCount)!!} Reply to " {{ Str::substr(App\Models\Comment::find($comment->parent_id)->body, 0, 25) }} {{ strlen(App\Models\Comment::find($comment->parent_id)->body) > 25 ? "...": "" }}"
                                </p>
                                @endif
                                <!-- Single Comment -->
                                <div class="single-comment">
                                    <img src="{{$comment->author->image == ''?'https://i.pravatar.cc/80?u='.$comment->author->id:image_crop($comment->author->image,80,80)}}" alt="#">
                                    <div class="content">
                                        <h4>{{$comment->author->name}} <span>{{$comment->created_at->diffForHumans()}}</span></h4>
                                        <p id="commentBody">{{$comment->body}}</p>
                                        <div class="button">
                                    {{-- javascript to update parent id when clicking the reply button --}}
                                    <a onclick="console.log({{$comment->id}});document.getElementById('parentId').setAttribute('value',{{$comment->id}})" href="#commentForm" class="btn"><i class="fa fa-reply"
                                    aria-hidden="true" ></i>Reply</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <a href="{{route('admin.comments.edit',$comment->id)}}" class=" m-2"><i class="ti ti-pencil"></i></a>
                                    <form action={{ route('admin.comments.delete_comment',['id'=>$comment->id,'currentPage'=>'post_detail']) }} method="post"
                                        class="m-2" id="deleteForm">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit"  id="deleteButton">
                                            
                                            <span><i class="ti ti-trash"></i></span>
                                        </button>
                                    </form>
                                </div>
                                </div>
                                <hr>
                                <!-- End Single Comment -->
                                <?php
                            if ($comment->children->count() > 0)
                            {  
                            $spaceCount +=1;
                            foreach ($comment->children as $commentReply){
                            generateCommentsList($commentReply,$spaceCount);
                            }
                        }
                                }
                                ?>
                                @foreach ($post->comments->where('parent_id',0) as $comment)                       {{generateCommentsList($comment)}}                      
                                @endforeach
                                {{-- <!-- Single Comment for child comment-->
                                <div class="single-comment left">
                                    <img src="https://via.placeholder.com/80x80" alt="#">
                                    <div class="content">
                                        <h4>john deo <span>Feb 28, 2018 at 8:59 pm</span></h4>
                                        <p>Enthusiastically leverage existing premium quality vectors with
                                            enterprise-wide innovation collaboration Phosfluorescently leverage others
                                            enterprisee Phosfluorescently leverage.</p>
                                        <div class="button">
                                            <a href="#" class="btn"><i class="fa fa-reply"
                                                    aria-hidden="true"></i>Reply</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Comment --> --}}
                            </div>
                        </div>
                        <div class="col-12" id="commentForm">
                            <div class="reply">
                                @auth
                                <div class="reply-head">
                                    <h2 class="reply-title">Leave a Comment</h2>
                                    <!-- Comment Form -->
                                    <form class="form" action="{{route('admin.comments.store')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                        <input type="hidden" name="post_id" value="{{$post->id}}">
                                        <input type="hidden" name="parent_id" value="" id="parentId">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <p id="replytext" class="mt-3 text-center"></p>
                                                    <label id="commentTitle">Your Comment<span>*</span></label>
                                                    <textarea name="body"required ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group button">
                                                    <button type="submit" class="btn">Post comment</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Comment Form -->
                                </div>
                                @else
                                {{session(['nextRoute'=>Route::currentRouteName(),'post_slug'=>$post->slug])}}
                                <a class="btn btn-primary text-white btn-block text-center" href="{{route('login')}}">Login to Comment</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="main-sidebar">
                    <!-- Single Widget -->
                    <div class="single-widget search">
                        <div class="form">
                            <input type="email" placeholder="Search Here...">
                            <a class="button" href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget category">
                        <h3 class="title">Blog Categories</h3>
                        <ul class="categor-list">
                            <li><a href="#">Men's Apparel</a></li>
                            <li><a href="#">Women's Apparel</a></li>
                            <li><a href="#">Bags Collection</a></li>
                            <li><a href="#">Accessories</a></li>
                            <li><a href="#">Sun Glasses</a></li>
                        </ul>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget recent-post">
                        <h3 class="title">Recent post</h3>
                        <!-- Single Post -->
                        <div class="single-post">
                            <div class="image">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                            </div>
                            <div class="content">
                                <h5><a href="#">Top 10 Beautyful Women Dress in the world</a></h5>
                                <ul class="comment">
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>Jan 11, 2020</li>
                                    <li><i class="fa fa-commenting-o" aria-hidden="true"></i>35</li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Post -->
                        <!-- Single Post -->
                        <div class="single-post">
                            <div class="image">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                            </div>
                            <div class="content">
                                <h5><a href="#">Top 10 Beautyful Women Dress in the world</a></h5>
                                <ul class="comment">
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>Mar 05, 2019</li>
                                    <li><i class="fa fa-commenting-o" aria-hidden="true"></i>59</li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Post -->
                        <!-- Single Post -->
                        <div class="single-post">
                            <div class="image">
                                <img src="https://via.placeholder.com/100x100" alt="#">
                            </div>
                            <div class="content">
                                <h5><a href="#">Top 10 Beautyful Women Dress in the world</a></h5>
                                <ul class="comment">
                                    <li><i class="fa fa-calendar" aria-hidden="true"></i>June 09, 2019</li>
                                    <li><i class="fa fa-commenting-o" aria-hidden="true"></i>44</li>
                                </ul>
                            </div>
                        </div>
                        <!-- End Single Post -->
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget side-tags">
                        <h3 class="title">Tags</h3>
                        <ul class="tag">
                            <li><a href="#">business</a></li>
                            <li><a href="#">wordpress</a></li>
                            <li><a href="#">html</a></li>
                            <li><a href="#">multipurpose</a></li>
                            <li><a href="#">education</a></li>
                            <li><a href="#">template</a></li>
                            <li><a href="#">Ecommerce</a></li>
                        </ul>
                    </div>
                    <!--/ End Single Widget -->
                    <!-- Single Widget -->
                    <div class="single-widget newsletter">
                        <h3 class="title">Newslatter</h3>
                        <div class="letter-inner">
                            <h4>Subscribe & get news <br> latest updates.</h4>
                            <div class="form-inner">
                                <input type="email" placeholder="Enter your email">
                                <a href="#">Submit</a>
                            </div>
                        </div>
                    </div>
                    <!--/ End Single Widget -->
                </div>
            </div>
        </div>
    </div>
</section>
<!--/ End Blog Single -->
<!-- end of blogs -->
@endsection


@section('scripts')
    <script>
        document.getElementById("blog").classList.add("active");
        document.getElementById("commentForm").addEventListener("mouseenter",()=>{
        let replyValue = document.getElementById("parentId").getAttribute("value");
        let commentBody = document.getElementById("commentBody").innerText;
        if(replyValue > 0){
        document.getElementById("replytext").innerHTML="You are replying to comment : "+commentBody;
        }
        });
        document.getElementById("commentForm").addEventListener("mouseleave",()=>{
            document.getElementById("parentId").setAttribute("value","");
            document.getElementById("replytext").innerHTML="";
        })
    </script>
@endsection
