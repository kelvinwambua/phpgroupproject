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

export default function VerifyTwoFactor() {
  const { data, setData, post, processing, errors } = useForm({
    code: '',
  });

  const submit = (e) => {
    e.preventDefault();
    post(route('2fa.verify'), {
      onSuccess: () => setData('code', ''),
    });
  };

  const handleLogout = (e) => {
    e.preventDefault();
    router.post(route('logout'));
  };

  return (
    <AuthLayout
      title="Confirm Login"
      description="Enter the 6-digit code we sent to your email to finish signing in."
    >
      <Head title="Two-Factor Verification" />

      <form onSubmit={submit} className="space-y-6 text-center mt-6">
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

        {errors.code && <p className="text-sm text-red-500">{errors.code}</p>}

        <Button type="submit" variant="secondary" disabled={processing}>
          {processing && <LoaderCircle className="h-4 w-4 animate-spin mr-2" />}
          {processing ? 'Verifying...' : 'Verify Code'}
        </Button>

        <Button type="button" variant="outline" onClick={handleLogout}>
          Logout
        </Button>
      </form>
    </AuthLayout>
  );
}
