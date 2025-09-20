import { Head, useForm, router } from '@inertiajs/react';
import { LoaderCircle } from 'lucide-react';

import AuthLayout from '@/layouts/auth-layout';
import { Button } from '@/components/ui/button';
import {
  InputOTP,
  InputOTPGroup,
  InputOTPSeparator,
  InputOTPSlot,
} from "@/components/ui/input-otp";
import { route } from 'ziggy-js';

export default function VerifyEmail() {
  // Inertia form state
  const { data, setData, post, processing, errors } = useForm({
    code: '', // OTP input
  });

  const submit = (e: React.FormEvent<HTMLFormElement>) => {
  e.preventDefault();
  post(route('verification.verify-otp'), {
    onSuccess: () => setData('code', ''), 
    onError: (errors) => console.log(errors), 
  });
};


  const handleLogout = (e: React.MouseEvent<HTMLButtonElement>) => {
    e.preventDefault();
    router.post(route('logout'));
  };

  return (
    <AuthLayout
      title="Verify Email"
      description="Enter the 6-digit code we sent to your email."
    >
      <Head title="Email Verification" />

      <form onSubmit={submit} className="flex flex-col items-center space-y-4">
        {/* OTP Input */}
        <div className="flex justify-center">
          <InputOTP
            maxLength={6}
            value={data.code}
            onChange={(value) => setData('code', value)}
          >
            <InputOTPGroup>
              <InputOTPSlot index={0} />
              <InputOTPSlot index={1} />
              <InputOTPSlot index={2} />
            </InputOTPGroup>
            <InputOTPSeparator />
            <InputOTPGroup>
              <InputOTPSlot index={3} />
              <InputOTPSlot index={4} />
              <InputOTPSlot index={5} />
            </InputOTPGroup>
          </InputOTP>
        </div>

        {/* Display validation error */}
        {errors.code && (
          <p className="text-sm text-red-500">{errors.code}</p>
        )}

        {/* Verify Button */}
        <Button
          type="submit"
          variant="secondary"
          disabled={processing}
          className="w-full"
        >
          {processing && (
            <LoaderCircle className="h-4 w-4 animate-spin mr-2" />
          )}
          {processing ? 'Verifying...' : 'Verify'}
        </Button>

        {/* Logout Button */}
        <Button
          type="button"
          variant="outline"
          onClick={handleLogout}
          className="w-full"
        >
          Logout
        </Button>
      </form>

    </AuthLayout>
  );
}
