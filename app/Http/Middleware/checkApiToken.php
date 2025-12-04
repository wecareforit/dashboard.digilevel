<?PHP

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;
class checkApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        // Step 1: Check if header exists
        if (!$header) {
            return response()->json(['error' => 'Authorization header missing'], 401);
        }

        // Step 2: Check if header starts with 'Bearer '
        if (!str_starts_with($header, 'Bearer ')) {
            return response()->json(['error' => 'Invalid Authorization header format'], 401);
        }

        $tokenValue = substr($header, 7); // Remove 'Bearer ' prefix

        // Step 3: Look up token in database
        $token = ApiToken::where('token', $tokenValue)->first();

        if (!$token) {
            return response()->json(['error' => 'Token not found in database'], 401);
        }

        // Step 4: Check for expiry (optional)
        if ($token->expires_at && $token->expires_at->isPast()) {
            return response()->json(['error' => 'Token expired'], 401);
        }

        // Optional: attach user to request
        if ($token->user) {
            $request->merge(['user' => $token->user]);
        }

        return $next($request);
    }
}
