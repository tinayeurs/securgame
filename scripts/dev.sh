#!/usr/bin/env bash
set -euo pipefail

docker compose up -d postgres
npm install
npm run prisma:generate
npm run prisma:migrate -- --name init
npm run prisma:seed
npm run dev
