<main style="display: flex; align-items: center; justify-content: center; height: 500px;">
    <form action="{{ route('chat.send') }}" method="POST">
        @csrf
        <input type="text" name="message">
        <input type="submit" value="Send">
    </form>
</main>
